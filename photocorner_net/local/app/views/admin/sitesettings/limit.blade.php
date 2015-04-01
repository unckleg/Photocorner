@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-wrench"></i></small>
            Podešavanje Ograničenja
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}
        <div class="form-group">
            <label for="addnew">Broj slika u Foto Galeriji</label>
            <select name="numberOfImages" class="form-control">
                <option value="{{ perPage() }}">{{ perPage() }}</option>
                <option>--------</option>
                @for($i=1;$i<=100;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="addnew">Automatski odobri Fotografije</label>
            <select name="autoApprove" class="form-control">
                @if(siteSettings('autoApprove') == 1)
                <option value="1">Da</option>
                @else
                <option value="0">Ne</option>
                @endif
                <option>--------</option>
                <option value="1">Da</option>
                <option value="0">Ne ( dozvola admina je potrebna )</option>
            </select>
        </div>

        <div class="form-group">
            <label for="addnew">Dozvoli preuzimanje Fotografija</label>
            <select name="allowDownloadOriginal" class="form-control">
                @if(siteSettings('allowDownloadOriginal') == '1')
                <option value="1">Yes</option>
                @elseif(siteSettings('allowDownloadOriginal') == '0')
                <option value="0">No</option>
                @elseif(siteSettings('allowDownloadOriginal') == 'leaveToUser')
                <option value="leaveToUser">Ostavi na Korisniku</option>
                @endif
                <option>--------</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
                <option value="leaveToUser">Ostavi na Korisniku</option>
            </select>
        </div>

        <div class="form-group">
            <label for="addnew">Limit za otpremanje Fotografija u toku jednog dana</label>
            <select name="limitPerDay" class="form-control">
                <option value="{{ limitPerDay() }}">{{ limitPerDay() }}</option>
                <option>--------</option>
                <?php for ($l = 1; $l <= 500; $l++): ?>
                    <option value="{{ $l }}">{{ $l }}</option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="addnew">Limit Oznaka</label>
            <select name="tagsLimit" class="form-control">
                <option value="{{ (int)siteSettings('tagsLimit') }}">{{ (int)siteSettings('tagsLimit') }}</option>
                <option>--------</option>
                <?php for ($l = 1; $l <= 30; $l++): ?>
                    <option value="{{ $l }}">{{ $l }}</option>
                <?php endfor; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="addnew">Najveća dozvoljena veličina Fotografije u MB</label>
            <select name="maxImageSize" class="form-control">
                <option value="{{ siteSettings('maxImageSize') }}">{{ siteSettings('maxImageSize') }}</option>
                <option>--------</option>
                <?php for ($l = 1; $l <= maxUploadSize(); $l += .5): ?>
                    <option value="{{ $l }}">{{ $l }}</option>
                <?php endfor; ?>
            </select>
        </div>


        <div class="form-group">
            {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
