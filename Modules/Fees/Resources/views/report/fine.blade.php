@extends('backEnd.master')
@section('title')
    @lang('fees::feesModule.fine_report')
@endsection
@section('mainContent')

    <style>
        #table_id_wrapper {
            margin-top: 50px;
        }

        table.dataTable thead .sorting_asc::after {
            top: 10px !important;
            left: 3px !important;
        }

        table.dataTable thead .sorting::after {
            top: 10px !important;
            left: 3px !important;
        }
    </style>

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('fees::feesModule.fine_report')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('fees::feesModule.fees')</a>
                    <a href="#">@lang('fees::feesModule.report')</a>
                    <a href="#">@lang('fees::feesModule.fine_report')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'route' => 'fees.fine-search', 'method' => 'POST']) }}
                        @include('fees::report._searchForm')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            @isset($fees_dues)
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 search_hide_md">
                                <x-table>
                                    <table id="table_id" class="table fees-report-footer" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.sl')</th>
                                                <th>@lang('student.admission_no')</th>
                                                <th>@lang('student.roll_no')</th>
                                                <th>@lang('common.name')</th>
                                                <th>@lang('fees::feesModule.due_date')</th>
                                                <th>@lang('fees::feesModule.fine') ({{ generalSetting()->currency_symbol }})</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalFine = 0;
                                            @endphp
                                            @foreach ($fees_dues as $key => $fees_due)
                                                @php
                                                    $fine = $fees_due->Tfine;
                                                    $totalFine += $fine;
                                                @endphp
                                                @if ($fine != 0)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ @$fees_due->studentInfo->admission_no }}</td>
                                                        <td>{{ @$fees_due->recordDetail->roll_no }}</td>
                                                        <td>{{ @$fees_due->studentInfo->full_name }}</td>
                                                        <td>{{ dateConvert($fees_due->due_date) }}</td>
                                                        <td>{{ $fine }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right">@lang('dashboard.total')</td>
                                                <td>{{ $totalFine }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.date_range_picker_css_js')
@push('script')
    <script type="text/javascript" src="{{ url('Modules\Fees\Resources\assets\js\app.js') }}"></script>
@endpush
