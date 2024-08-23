<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PostOrder;
use App\Models\StatusOrder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class feController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false; // Set false untuk sandbox mode, true untuk production mode
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    public function index()
    {
        return view('pelanggan.index');
    }
    public function showlogin()
    {
        // return auth()->guard('customer');
        return view('pelanggan.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return view('pelanggan.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showRegister()
    {
        return view('pelanggan.register');
    }
    public function contact()
    {
        return view('pelanggan.contact');
    }
    public function about()
    {
        return view('pelanggan.about');
    }

    public function profile()
    {
        // Ambil data customer yang sedang login
        $customer = Auth::guard('customer')->user();

        // Kirim data customer ke view
        return view('pelanggan.profile', compact('customer'));
    }

    public function orderHistory()
    {
        $customer = Auth::guard('customer')->user();
        $history = StatusOrder::join('orders', 'status_orders.order_id', '=', 'orders.id')
            ->where('orders.customer_id', $customer->id)
            ->select('status_orders.*')
            ->get();
        return view('pelanggan.riwayat', compact('history'));
    }

    public function completeOrder($id)
    {
        // Cari status order berdasarkan ID
        $statusOrder = StatusOrder::findOrFail($id);

        // Ubah status_paket menjadi 'Selesai'
        $statusOrder->status_paket = 'Selesai';

        // Simpan perubahan
        $statusOrder->save();

        // Redirect kembali ke halaman riwayat dengan pesan sukses
        return redirect()->route('orderhistory')->with('success', 'Orderan telah selesai.');
    }

    public function editprofile()
    {
        $customer = Auth::guard('customer')->user();
        return view('pelanggan.editprofile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        // Update data customer
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile_pictures'), $filename);

            // Delete old profile picture if exists
            if ($customer->img && file_exists(public_path('uploads/profile_pictures/' . $customer->img))) {
                unlink(public_path('uploads/profile_pictures/' . $customer->img));
            }

            $customer->img = $filename;
        }

        $customer->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function shop()
    {
        $perPage = 8;
        $products = Product::paginate($perPage);
        return view('pelanggan.shop', compact('products'));
    }
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('pelanggan.detail', compact('product'));
    }

    public function cart()
    {
        $customer = Auth::guard('customer')->user();
        $cartItems = $customer->cartItems()->with('product')->get();

        // Hitung ulang subtotal
        $subtotal = 0;
        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->product->price * $cartItem->qty;
        }

        // Set total sama dengan subtotal sementara karena tidak ada biaya pengiriman
        $total = $subtotal ;

        return view('pelanggan.cart', compact('cartItems', 'subtotal', 'total'));
    }

    public function addcart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $customer = Auth::guard('customer')->user();

        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity'); // Ambil nilai quantity dari request

        // Cek apakah produk sudah ada di keranjang belanja customer
        $cartItem = $customer->cartItems()->where('product_id', $product_id)->first();

        if ($cartItem) {
            // Jika produk sudah ada, tambahkan jumlahnya
            $cartItem->update([
                'qty' => $cartItem->qty + $quantity, // Perbarui kolom 'qty' sesuai nilai quantity baru
                'total_price' => $cartItem->product->price * ($cartItem->qty + $quantity)
            ]);
        } else {
            // Jika produk belum ada, tambahkan produk ke keranjang belanja
            $product = Product::findOrFail($product_id);
            $total_price = $product->price * $quantity;
            $customer->cartItems()->create([
                'product_id' => $product_id,
                'qty' => $quantity,
                'total_price' => $total_price
            ]);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
    }
    public function removecart(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();

        // Cari item keranjang berdasarkan ID
        $cartItem = Cart::findOrFail($id);

        // Pastikan bahwa item keranjang dimiliki oleh customer yang sedang login
        if ($cartItem->customer_id === $customer->id) {
            // Hapus item keranjang
            $cartItem->delete();

            return redirect()->route('cart')->with('success', 'Item removed from cart successfully!');
        } else {
            // Jika item keranjang tidak dimiliki oleh customer yang sedang login, beri respons yang sesuai
            return redirect()->route('cart')->with('error', 'You are not authorized to remove this item from cart.');
        }
    }
    public function checkout(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $cartItems = $customer->cartItems()->with('product')->get();

        // Hitung ulang subtotal
        $subtotal = 0;
        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->product->price * $cartItem->qty;
        }
        // Hitung biaya pengiriman berdasarkan lokasi dan berat
        $shippingCost = 0;
        $location = $request->input('location');

        if (in_array($location, [
    'jakarta', 'bogor', 'depok', 'tangerang', 'bekasi',
    'cikarang', 'tangerang selatan', 'ciputat', 'bintaro'
])) {
    // Zona 1: Jabodetabek
    $shippingCost = 15000; // Sesuaikan tarif JNE
} else if (in_array($location, [
    'bandung', 'surabaya', 'semarang', 'solo', 'yogyakarta', 'malang',
    'cirebon', 'tasikmalaya', 'purwokerto', 'magelang', 'kediri',
    'madiun', 'tegal', 'pasuruan', 'blitar', 'probolinggo', 'jember'
])) {
    // Zona 2: Pulau Jawa selain Jabodetabek
    $shippingCost = 25000; // Sesuaikan tarif JNE
} else if (in_array($location, [
    'medan', 'palembang', 'padang', 'batam', 'bali',
    'pekanbaru', 'lampung', 'jambi', 'bengkulu', 'palu',
    'pangkal pinang', 'tanjung pinang', 'batu', 'denpasar'
])) {
    // Zona 3: Pulau Sumatra dan Bali
    $shippingCost = 40000; // Sesuaikan tarif JNE
} else if (in_array($location, [
    'makassar', 'balikpapan', 'samarinda', 'pontianak', 'manado',
    'mataram', 'kupang', 'ambon', 'ternate', 'kendari',
    'palangkaraya', 'tarakan', 'banjarmasin', 'gorontalo'
])) {
    // Zona 4: Pulau Kalimantan, Sulawesi, Nusa Tenggara, Maluku
    $shippingCost = 50000; // Sesuaikan tarif JNE
} else if (in_array($location, [
    'jayapura', 'biak', 'merauke', 'sorong', 'timika'
])) {
    // Zona 5: Papua
    $shippingCost = 80000; // Sesuaikan tarif JNE
}

        // Hitung PPN 10%
        $ppn = $subtotal * 0.1;
        // Hitung total amount
        $totalAmount = $subtotal + $shippingCost + $ppn;

        // Kembalikan view dengan data yang diperlukan
        return view('pelanggan.checkout', compact('customer', 'cartItems', 'subtotal', 'totalAmount', 'shippingCost', 'ppn'));
    }


    public function paymentProcess(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $cartItems = $customer->cartItems()->with('product')->get();

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->product->price * $cartItem->qty;
        }

        // Calculate shipping cost based on location from the request
        $location = $request->input('location');
        $shippingCost = 0;

        if (in_array($location, [
            'jakarta',
            'bogor',
            'depok',
            'tangerang',
            'bekasi',
            'cikarang',
            'tangerang selatan',
            'ciputat',
            'bintaro'
        ])) {
            $shippingCost = 15000;
        } else if (in_array($location, [
            'bandung',
            'surabaya',
            'semarang',
            'solo',
            'yogyakarta',
            'malang',
            'cirebon',
            'tasikmalaya',
            'purwokerto',
            'magelang',
            'kediri',
            'madiun',
            'tegal',
            'pasuruan',
            'blitar',
            'probolinggo',
            'jember'
        ])) {
            $shippingCost = 25000;
        } else if (in_array($location, [
            'medan',
            'palembang',
            'padang',
            'batam',
            'bali',
            'pekanbaru',
            'lampung',
            'jambi',
            'bengkulu',
            'palu',
            'pangkal pinang',
            'tanjung pinang',
            'batu',
            'denpasar'
        ])) {
            $shippingCost = 40000;
        } else if (in_array($location, [
            'makassar',
            'balikpapan',
            'samarinda',
            'pontianak',
            'manado',
            'mataram',
            'kupang',
            'ambon',
            'ternate',
            'kendari',
            'palangkaraya',
            'tarakan',
            'banjarmasin',
            'gorontalo'
        ])) {
            $shippingCost = 50000;
        } else if (in_array($location, [
            'jayapura',
            'biak',
            'merauke',
            'sorong',
            'timika'
        ])) {
            $shippingCost = 80000;
        }

        // Hitung PPN 10%
        $ppn = $subtotal * 0.1;

        // Total amount to be charged (subtotal + shipping cost)
        $total = $subtotal + $shippingCost + $ppn;

        // Prepare item details array
        $itemDetails = [];

        foreach ($cartItems as $cartItem) {
            $itemDetails[] = [
                'id' => $cartItem->product->id,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->qty,
                'name' => $cartItem->product->name,
            ];
        }

        // Include shipping cost in the item details
        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ];
        }
        if ($ppn > 0) {
            $itemDetails[] = [
                'id' => 'ppn',
                'price' => $ppn,
                'quantity' => 1,
                'name' => 'ppn',
            ];
        }

        // Transaction parameters for Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . uniqid(),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan data order ke database
            $order = Order::create([
                'customer_id' => $customer->id,
                'code_order' => $params['transaction_details']['order_id'],
                'total_price' => $subtotal + $ppn,
                'shippingcost' => $shippingCost,
                'total' => $total,
            ]);

            // Simpan setiap item dari keranjang belanja ke dalam tabel order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                ]);
            }

            // Update stok produk setelah order
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                $product->stok -= $item->qty; // Pastikan 'stock' adalah nama kolom yang benar
                $product->save();
            }

            // Simpan data statusorder
            StatusOrder::create([
                'order_id' => $order->id,
                'date' => now(),
                'status' => 'Unpaid',
            ]);

            // Hapus semua item di cart
            $customer->cartItems()->delete();

            // Update status postorder menjadi Paid
            StatusOrder::where('order_id', $order->id)->update(['status' => 'Paid']);

            // Kirim snap token dan customer ke view checkout
            return view('pelanggan.checkout', compact('snapToken', 'customer', 'shippingCost', 'cartItems', 'subtotal', 'total', 'ppn'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        $notification = new Notification();
        $orderId = $notification->order_id;
        $status = $notification->transaction_status;

        // Handle callback Midtrans
        if ($status == 'capture') {
            // Update status postorder menjadi sudah dibayar
            StatusOrder::where('order_id', $orderId)->update(['status' => 'Paid']);
        } elseif ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
            // Update status StatusOrders menjadi dibatalkan
            StatusOrder::where('order_id', $orderId)->update(['status' => 'Cancelled']);
        }

        // Redirect user back to the index page
        return redirect()->route('index')->with('success', 'Pembayaran berhasil!');
    }
    public function categories()
    {
        $categories = Category::all();
        return view('pelanggan.categories', compact('categories'));
    }

    public function category($id)
    {
        $category = Category::find($id);
        $products = Product::where('category_id', $id)->get();
        return view('pelanggan.category', compact('category', 'products'));
    }
}
