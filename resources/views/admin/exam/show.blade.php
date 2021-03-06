@extends('layouts.admin')
@section('title', @$exam_info->title . ' - Notice')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$exam_info->title }}</h3>
                </div>
                <div class="card-body card-format">
                    <div class="col-12 m-4">
                        @isset($exam_info->exam_routine)
                            @foreach ($exam_info->exam_routine as $key => $item)
                                <div>
                                    <b> Date : {{ @$key }} <br></b>
                                    @foreach ($item as $keya => $ek)
                                        @isset($subjects[$ek['subject']])
                                            - &nbsp; &nbsp; Shift : {{ @$keya }}
                                            &nbsp; Subject : {{ @$subjects[$ek['subject']] }} <br>

                                        @endisset
                                    @endforeach
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
