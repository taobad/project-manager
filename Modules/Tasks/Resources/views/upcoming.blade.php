@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">

        <section class="vbox">

            <section class="scrollable wrapper bg overflow-x-auto">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div class="">
                                        <div class="lobilists-wrapper lobilists single-line sortable ps-container
                                            ps-theme-dark ps-active-x">

                                            @widget('Tasks\Overdue')
                                            @widget('Tasks\Today')
                                            @widget('Tasks\ThisWeek')

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </section>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>


@endsection