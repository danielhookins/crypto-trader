@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Game</div>

                <div class="card-body">
                  <p><strong>Cash: </strong>${{ $game->cash }}</p>
                  <p><strong>Bitcoin: </strong>{{ $game->bitcoin }}
                    (${{ $game->bitcoin * $btcPrice }})</p>

                    <h3>Trade</h3>

                    <form action="/buy" method="post">
                      {{ csrf_field() }}
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input name="cash" type="text" class="form-control"
                              placeholder="Buy Amount (Cash)">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Buy</button>
                          </div>
                      </div>
                    </form>

                    <form action="/sell" method="post">
                      {{ csrf_field() }}
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">BTC</span>
                        </div>
                        <input name="bitcoin" type="text" class="form-control"
                            placeholder="Sell Amount (Bitcoin)">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="submit">Sell</button>
                        </div>
                      </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Prices</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><strong>BTC Price: </strong>${{ $btcPrice }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trades</div>

                <div class="card-body">
                  <h3>Trade History</h3>
                    <table class="table">
                    @foreach($trades as $trade)
                      <tr>
                        <td>{{ $trade->direction }}</td>
                        <td>{{ $trade->quantity }}</td>
                        <td>{{ $trade->dollar_value }}</td>
                      </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
