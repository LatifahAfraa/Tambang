@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Keterangan Penolakan Checkout</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('checkout.ket', $transaksi->transaksi_id) }}" method="post">
                @csrf
                @method('put')
                <label for="keterangan">Keterangan Penolakan</label>
                <div class="form-group">
                    <input type="text" name="keterangan" value="{{ $transaksi->keterangan }}" class="form-control">
                </div>



                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

