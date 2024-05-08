<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginate = 3;
        //$orders = auth()->user()->orders()->get()->paginate(2);
        if (isset($_GET['order']) && $_GET['order'] == 'owners') $orders = Order::where('user_id', auth()->user()->id)->orderby('owners', 'ASC')->paginate($paginate);
        else $orders = Order::where('user_id', auth()->user()->id)->paginate($paginate);
        return view('orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $cadastral = $request->cadastral;
        $address = '';
        $date_create = '';
        $date_update = '';
        $owners = 1;
        $restrictions = 0;

        // Получаем сначала objectId
        $data = Http::withOptions([
            'verify' => false,
        ])->get('http://rosreestr.gov.ru/fir_rest/api/fir/fir_objects/'.$cadastral);
        if(!empty($data->object()) && $data->status() == 200) {
            $objectId = $data->object()[0]->objectId;
            $address = $data->object()[0]->addressNotes;
        }
        else {
            return 'error';
        }

        // Используя $objectId забираем данные из другого API
        $data = Http::withOptions([
            'verify' => false,
        ])->get('https://rosreestr.gov.ru/fir_rest/api/fir/fir_egrp_object/'.$objectId);
        if(!empty($data->object()) && $data->status() == 200) {
            $rights = $data->object()->realty->rights;
            // Получаем права на собственность с rightState = 1
            foreach ($rights as $v) {
                if($v->rightState != 1) continue;
                $rights = $v;
                break;
            }
        $date_create = $rights->dateC;
        $date_update = $rights->dateL;
        //dd($rights, $data->object());
        }
        else {
            return 'error';
        }

        // Насколько я понял, если rightState = 1, то это собственник один и без обременений, соответственно тащить из АПИ нечего, оставляю пока значения по умолчаниию
        // Пишем в базу
        $order = new Order();
        $order->user_id = $user_id;
        $order->cadastral_number = $cadastral;
        $order->address = $address;
        $order->date_create = $date_create;
        $order->date_update = $date_update;
        $order->owners = $owners;
        $order->restrictions = $restrictions;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Заявка принята');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
