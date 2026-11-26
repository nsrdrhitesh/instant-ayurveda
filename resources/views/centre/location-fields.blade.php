<label>Name<input name="name" value="{{ old('name',$location->name ?? '') }}" required></label>
<label>Address<textarea name="address">{{ old('address',$location->address ?? '') }}</textarea></label>
<label>City<input name="city" value="{{ old('city',$location->city ?? '') }}" required></label>
<label>State<input name="state" value="{{ old('state',$location->state ?? 'Maharashtra') }}" required></label>
<label>Postal code<input name="postal_code" value="{{ old('postal_code',$location->postal_code ?? '') }}"></label>
<label>Phone<input name="phone" value="{{ old('phone',$location->phone ?? '') }}"></label>
<label>Email<input type="email" name="email" value="{{ old('email',$location->email ?? '') }}"></label>
<label>Map URL<input type="url" name="map_url" value="{{ old('map_url',$location->map_url ?? '') }}"></label>
<label>Opening hours<input name="opening_hours" value="{{ old('opening_hours',$location->opening_hours ?? '') }}"></label>
<label>Display order<input type="number" name="display_order" value="{{ old('display_order',$location->display_order ?? 0) }}" min="0" max="999" required></label>
<label class="check"><input type="checkbox" name="published" value="1" @checked(old('published',$location->published ?? true))>Published</label>
<label class="check"><input type="checkbox" name="featured" value="1" @checked(old('featured',$location->featured ?? false))>Featured</label>
