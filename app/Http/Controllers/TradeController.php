<?php

namespace App\Http\Controllers;

use App\Trade;
use App\Game;
use Auth;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function buy(Request $request) {
        // user purchase
        $cash = $request->input('cash');

        // bitcoin price
        $jsonurl = "https://api.coinbase.com/v2/prices/spot?currency=USD";
        $json = file_get_contents($jsonurl);
        $bitcoin = json_decode($json);
        $btcPrice = (float) $bitcoin->data->amount;

        $btcBuy = $cash / $btcPrice;

        // game data
        $game = Game::where('user_id', Auth::user()->id)->first();
        $game->update([
          'cash' => ($game->cash - $cash),
          'bitcoin' => ($game->bitcoin + $btcBuy)
        ]);

        // create trade record
        $trade = Trade::create([
          'game_id' => $game->id,
          'direction' => 'buy',
          'coin_type' => 'BTC',
          'quantity' => $btcBuy,
          'dollar_value' => $cash
        ]);

        return redirect('home');
    }

    public function sell(Request $request) {
        // user sell
        $sellBtc = (float) $request->input('bitcoin');

        // bitcoin price
        $jsonurl = "https://api.coinbase.com/v2/prices/spot?currency=USD";
        $json = file_get_contents($jsonurl);
        $bitcoin = json_decode($json);
        $btcPrice = (float) $bitcoin->data->amount;

        // game data
        $game = Game::where('user_id', Auth::user()->id)->first();

        $game->update([
          'cash' => ($game->cash + ($btcPrice * $sellBtc)),
          'bitcoin' => ($game->bitcoin - $sellBtc)
        ]);

        // create trade record
        $trade = Trade::create([
          'game_id' => $game->id,
          'direction' => 'sell',
          'coin_type' => 'BTC',
          'quantity' => $sellBtc,
          'dollar_value' => (float) ($btcPrice * $sellBtc)
        ]);

        return redirect('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function edit(Trade $trade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trade $trade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade)
    {
        //
    }
}
