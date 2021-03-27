@extends('layout')

@section('title', __('home.title'))

@section('head')
    <script src="/js/vue.min.js"></script>
@endsection

@section('content')
    <div id="app" class="content">
        @auth
            <h1 class="title is-spaced">@lang('home.header_auth', ['user.firstname' => Auth::user()->firstname])</h1>

            <h2 class="subtitle is-5">@lang('home.holdings')</h1>

            <div class="box content" v-for="holding in holdings">
                <h3 class="title is-5">@{{ holding.name }} (@{{ holding.symbol }})</h3>
                <p>@lang('home.price'): <strong>@{{ holding.price }} USDT</strong></p>
                <p>@lang('home.amount'): <strong>@{{ parseFloat(holding.pivot.amount).toFixed(2) }} @{{ holding.symbol }}</strong> = <strong>@{{ (holding.pivot.amount  * (holding.price || 0)).toFixed(2) }} USDT</strong></h3>
            </div>
        @else
            <h1 class="title is-spaced">@lang('home.header_guest', ['app.name' => config('app.name')])</h1>
        @endauth
    </div>

    <script>
    var ws = undefined;
    var app = new Vue({
        el: '#app',

        data: {
            holdings: @json(Auth::user()->coins)
        },

        created: function () {
            var self = this;

            ws = new WebSocket('ws://localhost:8080/');

            ws.onmessage = function (event) {
                var data = JSON.parse(event.data);

                for (var i = 0; i < self.holdings.length; i++) {
                    var holding = self.holdings[i];

                    if (holding.symbol == data.c) {
                        Vue.set(holding, 'price', data.p);
                        break;
                    }
                }
            };
        }
    });
    </script>
@endsection
