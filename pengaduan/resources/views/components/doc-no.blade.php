@props(['id'])
{{-- Motif identitas (DESIGN.md): nomor register seperti nomor surat. --}}
<span {{ $attributes->merge(['class' => 'text-xs font-semibold tabular-nums text-indigo-700']) }}>No. {{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</span>
