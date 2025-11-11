<x-dashboard-layout :page-title="$pageTitle">
    @include('components.session-messages')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2 class="mb-4 text-white">🔒 Floor Scanning (Scan-Only List)</h2>
                    <input id="capture" type="text" inputmode="numeric" maxlength="15" autocomplete="off" placeholder="Scan QR code here..." class="form-control" style="position:absolute; left:-9999px; top:-9999px; opacity:0;">
                    <textarea id="dataBox" class="form-control mt-3 text-white bg-white" rows="2" placeholder="Create new scratch file from selection" readonly disabled></textarea>
                    <div id="msg" class="text-white"></div>
                </div>
                <div class="card-body" style="max-height:300px; overflow-y:auto;">
                    <ul id="qrList" class="list-group text-white"></ul>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="fw-bold text-white" id="totalCount">Total Scans: 0</div>
                    <div class="align-self-center">
                        <button id="saveBtn" class="btn btn-success">💾 Save & Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="qrForm" method="POST" action="{{ route('admin.data.store') }}" style="display:none;">
        @csrf
        <div id="hiddenInputs"></div>
    </form>

    <script>
        const capture = document.getElementById('capture');
        const qrList = document.getElementById('qrList');
        const totalCount = document.getElementById('totalCount');
        const saveBtn = document.getElementById('saveBtn');
        const msg = document.getElementById('msg');
        const hiddenInputs = document.getElementById('hiddenInputs');
        const qrForm = document.getElementById('qrForm');
        const dataBox = document.getElementById('dataBox');

        const MAX_LIMIT = 15000;
        const dataSet = new Set();
        let buffer = "";

        function showMessage(text, type){
            msg.style.display = 'block';
            msg.textContent = text;
            msg.style.color = type==='error' ? '#ff5555' : type==='duplicate' ? '#f59e0b' : '#ffffff';
            clearTimeout(msg._timer);
            msg._timer = setTimeout(()=>{ msg.style.display='none'; }, 2500);
        }

        function updateTotal(){
            totalCount.textContent = `Total Scans: ${dataSet.size}`;
        }

        function renderQR(qr){
            const li = document.createElement('li');
            li.className = 'list-group-item text-white';
            li.textContent = qr;
            qrList.appendChild(li);

            // Show only the latest scanned code
            dataBox.value = qr;

            const input = document.createElement('input');
            input.type='hidden';
            input.name='cn_no[]';
            input.value=qr;
            hiddenInputs.appendChild(input);
        }

        // BLOCK manual typing / paste / copy / cut / context menu
        ['paste','copy','cut','contextmenu'].forEach(evt=>{
            capture.addEventListener(evt, e=>{ e.preventDefault(); showMessage('Action disabled','error'); });
        });

        capture.addEventListener('keydown', e => {
            e.preventDefault(); // block all manual typing
            if(e.key.length === 1) buffer += e.key;
            if(e.key === "Enter"){
                const value = buffer.trim();
                buffer = "";
                if(!value) return;

                if(dataSet.size >= MAX_LIMIT){ showMessage('⚠️ Maximum limit reached','error'); return; }
                if(dataSet.has(value)){ showMessage('⚠️ Duplicate entry','duplicate'); return; }

                dataSet.add(value);
                renderQR(value);
                updateTotal();
                showMessage(`✅ Scanned: ${value}`, 'success');
            }
        });

        // Save form
        saveBtn.addEventListener('click', ()=>{
            if(dataSet.size===0){ showMessage('No data to save','error'); return; }
            qrForm.submit();
        });

        // Autofocus hidden capture
        window.addEventListener('load', ()=>{ capture.focus(); });
        document.addEventListener('click', ()=>{ capture.focus(); });
    </script>
</x-dashboard-layout>
