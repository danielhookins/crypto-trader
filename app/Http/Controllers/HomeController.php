<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Trade;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // bitcoin price
      $jsonurl = "https://api.coinbase.com/v2/prices/spot?currency=USD";
      $json = file_get_contents($jsonurl);
      $bitcoin = json_decode($json);
      $btcPrice = (float) $bitcoin->data->amount;

      // game data
      $game = Game::where('user_id', Auth::user()->id)->first();
      $trades = Trade::where('game_id', $game->id)->orderBy('updated_at', 'desc')->get();

      return view('home', compact('btcPrice', 'game', 'trades'));
    }
}
