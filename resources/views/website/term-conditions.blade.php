<div class="modal fade" id="policyModal" tabindex="-1" aria-labelledby="policyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="">
                    <div class="mb-3">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <ul class="nav nav-pills card-header-pills flex-grow-1" role="tablist" id="policyTab">
                                <li class="nav-item col-6" role="presentation">
                                    <button id="terms-tab" type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-within-card-active"
                                            aria-controls="navs-pills-within-card-active"
                                            aria-selected="true">
                                        Terms and Conditions
                                    </button>
                                </li>
                                <li class="nav-item col-6" role="presentation">
                                    <button id="privacy-tab" type="button" class="nav-link" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-within-card-link"
                                            aria-controls="navs-pills-within-card-link"
                                            aria-selected="false" tabindex="-1">
                                        Privacy Policy
                                    </button>
                                </li>
                            </ul>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-pills-within-card-active" role="tabpanel">
                                    <h5 class="mt-3">1. Terms</h5>
                                    <p>
                                        You are agreeing to be bound by these Website Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials contained in this Website are protected by copyright and trade mark law.
                                    </p>
                                    <h5 class="mt-3">2. Use License</h5>
                                    <p>
                                        Permission is granted to temporarily download one copy of the materials on RIO Reward's Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                                        <br>
                                        modify or copy the materials;
                                        <br>
                                        use the materials for any commercial purpose or for any public display;
                                        <br>
                                        attempt to reverse engineer any software contained on RIO Reward's Website;
                                        <br>
                                        remove any copyright or other proprietary notations from the materials; or
                                        <br>
                                        transferring the materials to another person or "mirror" the materials on any other server.
                                        <br>
                                        This will let RIO Reward to terminate upon violations of any of these restrictions. Upon termination, your viewing right will also be terminated and you should destroy any downloaded materials in your possession whether it is printed or electronic format. These Terms of Service has been created with the help of the Terms Of Service Generator.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-within-card-link" role="tabpanel">
                                    <h5 class="mt-3">Privacy Policy for RIO Reward</h5>
                                    <p>At RIO Reward, accessible from one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by RIO Reward and how we use it.
                                        If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                                    <h5>Log Files</h5>
                                    <p>RIO Reward follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services’ analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users’ movement on the website, and gathering demographic information. Our Privacy Policy was created with the help of the Privacy Policy Generator.</p>
                                    <h5>Cookies and Web Beacons</h5>
                                    <p>Like any other website, RIO Reward uses “cookies”. These cookies are used to store information including visitors’ preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users’ experience by customizing our web page content based on visitors’ browser type and/or other information.

                                        For more general information on cookies, please read the “Cookies” article from the Privacy Policy Generator.

                                        parent of e1b9ab7 ([brands] Updated credits link)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-dismiss="modal">Accept and Continue</button>
            </div>
        </div>
    </div>
</div>
<script>
    let pendingTab = null;

    function showPolicyTab(tab) {
        pendingTab = tab;
    }

    const policyModal = document.getElementById('policyModal');
    policyModal.addEventListener('shown.bs.modal', function () {
        if (!pendingTab) return;

        const triggerTab = document.querySelector(`#${pendingTab}-tab`);
        if (triggerTab) {
            const tabInstance = new bootstrap.Tab(triggerTab);
            tabInstance.show();
        }

        pendingTab = null; 
    });
</script>

