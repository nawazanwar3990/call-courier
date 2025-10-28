<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <h3 class="my-4">{{$pageTitle}}</h3>
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                    <tr>
                        <th>{{ trans('general.title') }}</th>
                        <th></th>
                        <th>{{ trans('general.datetime') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td>
                                @isset($history->giftCard)
                                    {{ $history->giftCard?->name }}
                                @else
                                    {{ $history->task?->task_name }}
                                @endisset
                            </td>
                            <td>
                                @isset($history->giftCard)
                                    <strong class="text-danger">
                                        -{{$history->coins}}
                                    </strong>
                                @else
                                    <strong class="text-success">
                                        +{{$history->coins}}
                                    </strong>
                                @endisset
                            </td>
                            <td>
                                {{$history->created_at}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-3">
                                {{ trans('general.no_history_found') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-website-layout>
