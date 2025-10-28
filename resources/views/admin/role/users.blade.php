<x-dashboard-layout :page-title="$pageTitle">
    <x-breadcrumb :page-title="$pageTitle" :bread-crumbs="$breadCrumbs" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover table-compact w-100" id="table">
                            <thead>
                            <tr>
                                <th>{{ __('general.name') }}</th>
                                <th>{{ __('general.email') }}</th>
                                <th>{{ __('general.username') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->user?->username }}
                                    </td>
                                    <td>
                                        {{ $user->user?->email }}
                                    </td>
                                    <td>
                                        {{ $user->user?->user_name }}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <x-buttons :cancel="true" :cancel-route="route('admin.roles.index')" />
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
