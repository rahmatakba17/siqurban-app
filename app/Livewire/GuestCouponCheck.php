<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Coupon;

class GuestCouponCheck extends Component
{
    public $searchCode = '';
    public $coupon = null;
    public $hasSearched = false;

    public function search()
    {
        $this->validate([
            'searchCode' => 'required|string|min:4'
        ], [
            'searchCode.required' => 'Silakan masukkan kode kupon.',
            'searchCode.min' => 'Kode kupon minimal 4 karakter.'
        ]);

        $this->coupon = Coupon::with(['region'])
            ->where('code', strtoupper(trim($this->searchCode)))
            ->first();

        $this->hasSearched = true;
    }

    public function resetSearch()
    {
        $this->searchCode = '';
        $this->coupon = null;
        $this->hasSearched = false;
    }

    public function render()
    {
        return view('livewire.guest-coupon-check');
    }
}
