<!--begin::Actions-->
<div class="d-flex align-items-center gap-2 gap-lg-3">
    @if(isset($secondary))
        <!--begin::Secondary button-->
        <a href="{{ $secondary['link'] ?? '#' }}"
           class="btn btn-sm fw-bold btn-secondary"
           @if(isset($secondary['modal']))
           data-bs-toggle="modal"
           data-bs-target="#{{ $secondary['modal'] }}"
           @endif>
           {{ $secondary['text'] }}
        </a>
        <!--end::Secondary button-->
    @endif

    @if(isset($primary))
        <!--begin::Primary button-->
        <a href="{{ $primary['link'] ?? '#' }}"
           class="btn btn-sm fw-bold btn-primary"
           @if(isset($primary['modal']))
           data-bs-toggle="modal"
           data-bs-target="#{{ $primary['modal'] }}"
           @endif>
           {{ $primary['text'] }}
        </a>
        <!--end::Primary button-->
    @endif
</div>
<!--end::Actions-->
