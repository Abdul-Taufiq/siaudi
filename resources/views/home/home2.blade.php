@extends('partial.main')
@section('konten')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="m-0" style="letter-spacing: 2px;">
                                    <b>{{ $title }}</b>
                                </h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <i class="fa fa-clock" aria-hidden="true"></i>
                                <b id="dateTime"></b> <span id="greeting"></span><br>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    Selamat datang kembali &nbsp;<b> {{ auth()->user()->nama }}</b>&nbsp;... &nbsp; 😊
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function updateDateTime() {
            var dateTimeContainer = document.getElementById('dateTime');
            var greetingContainer = document.getElementById('greeting');

            var currentDate = new Date();
            var currentHour = currentDate.getHours();
            var currentMinute = currentDate.getMinutes();
            var currentSecond = currentDate.getSeconds();

            var formattedTime = padZero(currentHour) + ':' + padZero(currentMinute) + ':' + padZero(currentSecond);
            var formattedDate = currentDate.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            dateTimeContainer.textContent = formattedDate + ', ' + formattedTime;
            greetingContainer.textContent = getGreeting(currentHour);
        }

        function getGreeting(hour) {
            if (hour >= 0 && hour < 10) {
                return ' Selamat Pagi';
            } else if (hour >= 10 && hour < 14) {
                return ' Selamat Siang';
            } else if (hour >= 14 && hour < 18) {
                return ' Selamat Sore';
            } else {
                return ' Selamat Malam';
            }
        }

        function padZero(number) {
            return (number < 10 ? '0' : '') + number;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
@endsection
