@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Checkin</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('adminAb.store.op2') }}" method="post">
                @csrf
                <label for="">ID Profile</label>
                <div class="form-group">
                   <select name="member_id" id="select-member" class="form-select" >
                    @foreach($member as $item)
                    <option value="{{ old('member_id') ? old ('member_id') : $item->member_id }}">
                        {{ $item->member_nama }}
                    </option>
                    @endforeach
                   </select>
                </div>
                <div class="form-group">

                <label for="">Kendaraan</label>
                <div class="form-group">
                   <select name="kendaraan_id" id="select-kendr" class="form-select">
                    @foreach($kendaraan as $item)
                    <option value="{{ old('kendaraan_id') ? old ('kendaraan_id') : $item->kendaraan_id }}">
                        {{ $item->no_pol }}
                    </option>
                    @endforeach
                   </select>
                </div>
                <div class="form-group">

               
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Checkin</button>
                    <a href="{{ route('adminAb.index.op2')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>


    
<script type="text/javascript">

        // $(document).ready(function() {
        //     $('#select-member').select2();
        // });

        // $(document).ready(function() {
        //     $('#select-kendr').select2();
        // });

    //dropdown dependent
    $(document).ready(function() {

    //  select province:start
    $('#select-member').select2({
    allowClear: true,
    ajax: {
        url: "{{ route('member.select.op2') }}",
        dataType: 'json',
        delay: 250,
        processResults: function(data) {
            return {
                results: $.map(data, function(item) {
                return {
                    text: item.member_nama,
                    id: item.member_id
                }
                })
            };
        }
    }
    });
    //  select province:end

    //  Event on change select province:start
    $('#select-member').change(function() {
    //clear select
    $('#select-kendr').empty();

    //set id
    let memberId = $(this).val();
    if (memberId) {
        $('#select-kendr').select2({
            allowClear: true,
            ajax: {
                url: "{{ route('kendaraan.select.op2') }}?memberId=" + memberId,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.no_pol,
                            id: item.kendaraan_id
                        }
                    })
                };
                }
            }
        });
    } else {
        $('#select-kendr').empty();
        
    }
    });
    //  Event on change select province:end

    //  Event on change select regency:start
    $('#select-kendr').change(function() {
    //clear select
    //set id
    let memberId = $(this).val();
    if (memberId) {
        $('#select-kendr').select2({
            allowClear: true,
            ajax: {
                url: "{{ route('kendaraan.select.op2') }}?memberId=" + memberId,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
                }
            }
        });
    } else {
        $("#select_district").empty();
        $("#select_village").empty();
    }
    });

        $('#select_member').on('select2:clear', function(e) {
        $("#select-kendr").select2();

        });

    });



</script>

@endsection

