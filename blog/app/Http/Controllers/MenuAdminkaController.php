<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Menu;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\URL;

class MenuAdminkaController extends Controller
{


    // AJAX Reordering function (update menu item orders by ajax)
    public function postIndex(Request $request)
    {
        $source = $request->input('source');
        $destination = $request->input('destination');
        $item = Menu::find($source);
        $item->parent_id = $destination;
        $item->save();

        $ordering = json_decode($request->input('order'));
        $rootOrdering = json_decode($request->input('rootOrder'));
        if($ordering){
            foreach($ordering as $order => $item_id){
                if($itemToOrder = Menu::find($item_id)){
                    $itemToOrder->order = $order;
                    $itemToOrder->save();
                }
            }
        } else {
            foreach($rootOrdering as $order=>$item_id){
                if($itemToOrder = Menu::find($item_id)){
                    $itemToOrder->order = $order;
                    $itemToOrder->save();
                }
            }
        }
        return 'ok ';
    }



    //destroy function
    public function postDelete(Request $request, $id)
    {
        // Find all items with the parent_id of this one and reset the parent_id to null
        $items = Menu::where('parent_id', $id)->get()->each(function($item)
        {
            $item->parent_id = 0;
            $item->save();
        });
        // Find and delete the item that the user requested to be deleted
        $item = Menu::findOrFail($id);
        $item->delete();
        Alert::info('You have successfully delete a menu.');

        return redirect(null, 200)->route('platform.menu.list');
    }
}
