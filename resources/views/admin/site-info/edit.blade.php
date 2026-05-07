@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Sayt ma'lumotlari (Aloqa sahifasi)
    </div>

    <div class="card-body">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.site-info.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="main_title">Sahifa sarlavhasi</label>
                <input type="text" name="main_title" id="main_title" class="form-control" value="{{ old('main_title', $siteInfo->main_title) }}" placeholder="Qabul jadvali">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone">Telefon (ko'rinadigan matn)</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $siteInfo->phone) }}" placeholder="+998 (99) 207-44-44">
                </div>
                <div class="form-group col-md-6">
                    <label for="phone_link">Telefon (link uchun, raqamlar)</label>
                    <input type="text" name="phone_link" id="phone_link" class="form-control" value="{{ old('phone_link', $siteInfo->phone_link) }}" placeholder="+998992074444">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="website">Veb-sayt</label>
                    <input type="text" name="website" id="website" class="form-control" value="{{ old('website', $siteInfo->website) }}" placeholder="http://ekolog.uz">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $siteInfo->email) }}" placeholder="ekolog@mail.ru">
                </div>
            </div>

            <hr>
            <h5>Ijtimoiy tarmoqlar</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="telegram_url">Telegram URL</label>
                    <input type="text" name="telegram_url" id="telegram_url" class="form-control" value="{{ old('telegram_url', $siteInfo->telegram_url) }}" placeholder="https://t.me/...">
                </div>
                <div class="form-group col-md-4">
                    <label for="facebook_url">Facebook URL</label>
                    <input type="text" name="facebook_url" id="facebook_url" class="form-control" value="{{ old('facebook_url', $siteInfo->facebook_url) }}" placeholder="https://facebook.com/...">
                </div>
                <div class="form-group col-md-4">
                    <label for="instagram_url">Instagram URL</label>
                    <input type="text" name="instagram_url" id="instagram_url" class="form-control" value="{{ old('instagram_url', $siteInfo->instagram_url) }}" placeholder="https://instagram.com/...">
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label for="address">Manzil</label>
                <textarea name="address" id="address" class="form-control" rows="2" placeholder="100043; O'zbekiston, Toshkent shahar, ...">{{ old('address', $siteInfo->address) }}</textarea>
            </div>

            <div class="form-group">
                <label for="transport">Transport (har bir qator alohida nuqta)</label>
                <textarea name="transport" id="transport" class="form-control" rows="3" placeholder="Metro bekati &quot;Buyuk Ipak Yo'li&quot;&#10;Masjid &quot;Mirzo Ulug'bek&quot;">{{ old('transport', $siteInfo->transport) }}</textarea>
            </div>

            <div class="form-group">
                <label for="working_hours">Ish vaqti (har bir qator alohida)</label>
                <textarea name="working_hours" id="working_hours" class="form-control" rows="4" placeholder="09:00 – 18:00&#10;Tushlik: 13:00 – 14:00&#10;Dam olish: Shanba, Yakshanba">{{ old('working_hours', $siteInfo->working_hours) }}</textarea>
            </div>

            <div class="form-group">
                <label for="map_embed">Xarita iframe src (Google Maps embed URL)</label>
                <textarea name="map_embed" id="map_embed" class="form-control" rows="3" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed', $siteInfo->map_embed) }}</textarea>
                <small class="form-text text-muted">Google Maps'dan "Embed a map" ni oching va <code>src="..."</code> ichidagi URL'ni shu yerga qo'ying.</small>
            </div>

            <button type="submit" class="btn btn-danger">Saqlash</button>
        </form>
    </div>
</div>
@endsection
