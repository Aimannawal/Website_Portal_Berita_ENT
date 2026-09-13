<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest('subscribed_at')->paginate(20);

        return view('subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function export()
    {
        $subscribers = Subscriber::latest('subscribed_at')->get(['email', 'subscribed_at']);

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Berlangganan Sejak']);

            foreach ($subscribers as $subscriber) {
                fputcsv($handle, [$subscriber->email, $subscriber->subscribed_at?->format('Y-m-d H:i')]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, 'pelanggan-newshub-' . now()->format('Ymd') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
