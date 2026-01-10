<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('user.address.index', compact('addresses'));
    }

    public function create()
    {
        return view('user.address.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ]);

        Address::create($request->all() + ['user_id' => Auth::id()]);

        return redirect()->route('user.addresses.index')->with('success', 'Alamat berhasil ditambahkan');
    }

    public function edit(Address $address)
    {
        // Pastikan user hanya bisa edit alamat miliknya
        if ($address->user_id !== Auth::id()) abort(403);

        return view('user.address.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $address->update($request->all());
        return redirect()->route('user.addresses.index')->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $address->delete();
        return back()->with('success', 'Alamat dihapus');
    }
}





