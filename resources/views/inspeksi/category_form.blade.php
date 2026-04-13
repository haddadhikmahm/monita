@extends('layouts.app')

@section('title', 'Form Kategori - Monita HUD')
@section('header', 'Inspeksi: ' . $kategori->nama)

@section('content')
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="edit-3" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">{{ $kategori->nama }}</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Detailed Equipment Surveillance</p>
            </div>
        </div>

        <form action="{{ route('inspeksi.save_category', $kategori->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="overflow-x-auto rounded-3xl border border-slate-100 shadow-sm bg-white mb-8">
                <table class="table-hud">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Peralatan</th>
                            <th width="10%">Qty</th>
                            <th width="20%">Status</th>
                            <th>Visual Doc</th>
                            <th width="25%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alats as $index => $item)
                            @php $detail = $existingDetails->get($item->id); @endphp
                            <tr class="border-b border-slate-50" data-id="{{ $item->id }}">
                                <td class="text-center font-mono text-[10px] text-slate-400">{{ $loop->iteration }}</td>
                                <td class="font-bold text-slate-800 text-sm">{{ $item->nama }}</td>
                                <td>
                                    <input type="number" name="items[{{ $item->id }}][jml]" 
                                           class="form-hud-input !py-2 !px-4 !rounded-xl !text-xs qty-input" 
                                           placeholder="Qty" 
                                           value="{{ $detail?->jumlah ?? '' }}" required>
                                </td>
                                <td>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="radio" name="items[{{ $item->id }}][kondisi]" value="Baik" 
                                                   class="condition-radio w-4 h-4 border-slate-200 text-aviation-success focus:ring-aviation-success/10"
                                                   {{ ($detail?->kondisi_struktur ?? 'Baik') == 'Baik' ? 'checked' : '' }}>
                                            <span class="text-[9px] font-black text-slate-500">BAIK</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="radio" name="items[{{ $item->id }}][kondisi]" value="Rusak" 
                                                   class="condition-radio w-4 h-4 border-slate-200 text-rose-500 focus:ring-rose-500/10"
                                                   {{ ($detail?->kondisi_struktur ?? '') == 'Rusak' ? 'checked' : '' }}>
                                            <span class="text-[9px] font-black text-slate-500">RUSAK</span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <input type="file" name="items[{{ $item->id }}][foto]" 
                                               class="block w-full text-[9px] text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-aviation-900/5 file:text-aviation-900">
                                        @if($detail?->foto)
                                            <input type="hidden" name="items[{{ $item->id }}][existing_foto]" value="{{ $detail->foto }}">
                                            <i data-lucide="image" class="w-4 h-4 text-aviation-success" title="File exists"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <textarea name="items[{{ $item->id }}][keterangan]" 
                                              class="form-hud-input !py-2 !px-3 !rounded-xl !text-xs keterangan-field" 
                                              placeholder="Catatan..." 
                                              rows="1">{{ $detail?->keterangan ?? '' }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between gap-4">
                <a href="{{ route('inspeksi.create') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Batal & Kembali
                </a>
                <button type="submit" class="btn-hud btn-hud-primary h-14 px-10">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Simpan Progress Kategori
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const checkValidation = () => {
            $('.condition-radio').each(function() {
                const tr = $(this).closest('tr');
                const keterangan = tr.find('.keterangan-field');
                const isRusak = tr.find('input[value="Rusak"]').is(':checked');
                
                if (isRusak) {
                    keterangan.attr('required', true);
                    keterangan.addClass('border-rose-300 bg-rose-50');
                } else {
                    keterangan.removeAttr('required');
                    keterangan.removeClass('border-rose-300 bg-rose-50');
                }
            });
        };

        $('.condition-radio').on('change', checkValidation);
        checkValidation(); // Initial call

        // Highlight Logic
        const urlParams = new URLSearchParams(window.location.search);
        const highlightId = urlParams.get('highlight');
        if (highlightId) {
            const row = $(`tr[data-id="${highlightId}"]`);
            if (row.length) {
                row.addClass('bg-amber-50 ring-2 ring-amber-500/20');
                $('html, body').animate({
                    scrollTop: row.offset().top - 150
                }, 1000);
            }
        }

        $('form').on('submit', function(e) {
            let allValid = true;
            $('.qty-input').each(function() {
                if ($(this).val() === '') allValid = false;
            });

            if (!allValid) {
                e.preventDefault();
                alert('MOHON ISI SEMUA QUANTITY ALAT');
                return false;
            }
        });
    });
</script>
@endsection
