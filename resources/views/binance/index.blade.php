@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card">
            <div class="card-header">
                Thống Kê
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center align-middle">
                                <th>#</th>
                                <th>Time</th>
                                <th>ETHUSDT FundingRate</th>
                                <th>ETHUSDT FundingRateDaily</th>
                                <th>ETHUSD FundingRate</th>
                                <th>ETHUSD FundingRateDaily</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in list">
                                <th class="text-center">@{{ index + 1 }}</th>
                                <td class="text-center">@{{ value.time_convert}}</td>
                                <td class="text-end">@{{ value.ETHUSDTFundingRate }}</td>
                                <td class="text-end">@{{ value.ETHUSDTFundingRateDaily }}</td>
                                <td class="text-end">@{{ value.ETHUSDFundingRate }}</td>
                                <td class="text-end">@{{ value.ETHUSDFundingRateDaily }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el      : "#app",
            data    : {
                list       : []
            },
            created() {
                this.getData();
            },
            methods : {
                getData() {
                    axios
                        .get('/data-binance')
                        .then((res) => {
                            this.list = res.data.data;
                        })
                }
            }
        });
    </script>
@endsection
