<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Region;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class KuponTable extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $type = '';

    #[Url]
    public int $region_id = 0;

    // Reset pagination when filters change
    public function updatedSearch(): void    { $this->resetPage(); }
    public function updatedStatus(): void    { $this->resetPage(); }
    public function updatedType(): void      { $this->resetPage(); }
    public function updatedRegionId(): void  { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset('search', 'status', 'type', 'region_id');
        $this->resetPage();
    }

    public function deleteCoupon(int $id): void
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        $this->dispatch('notify', message: 'Kupon ' . $coupon->code . ' berhasil dihapus.', type: 'success');
    }

    public function render()
    {
        $query = Coupon::with('region')->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                  ->orWhere('sacrificer_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status)    $query->where('status', $this->status);
        if ($this->type)      $query->where('type', $this->type);
        if ($this->region_id) $query->where('region_id', $this->region_id);

        return view('livewire.kupon-table', [
            'coupons'       => $query->paginate(15),
            'regions'       => Region::where('status', 'active')->orderBy('name')->get(),
            'totalCoupons'  => Coupon::count(),
            'totalReceived' => Coupon::where('status', 'received')->count(),
            'totalAvail'    => Coupon::where('status', 'available')->count(),
        ]);
    }
}
