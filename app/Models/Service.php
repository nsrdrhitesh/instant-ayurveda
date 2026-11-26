<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};
class Service extends Model {
 use SoftDeletes; protected $guarded=['id'];protected $attributes=['version'=>1,'status'=>'draft','schema_mode'=>'automatic'];
 protected function casts():array{return ['featured'=>'boolean','offer_verified'=>'boolean','noindex'=>'boolean','version'=>'integer'];}
 public function media(){return $this->belongsTo(Media::class);}public function sections(){return $this->hasMany(ServiceSection::class)->orderBy('display_order')->orderBy('id');}
 public function scopeEligible($q){return $q->where('status','published');}public function isPublic():bool{return !$this->trashed()&&$this->status==='published';}
 public function getPublicUrlAttribute():string{return url('/services/'.$this->slug);}public function getCanonicalAttribute():string{return $this->canonical_url?:$this->public_url;}
 public function facts(string $kind){return $this->sections->where('kind',$kind);}
    public function getImageUrlAttribute(): ?string
    {
        if ($this->media) {
            return $this->media->url;
        }

        $image = match ($this->slug) {
            'ayurvedic-medicine' => 'Ayurvedic-Medicine.jpg',
            'ayurvedic-surgery' => 'Ayurvedic-Surgery.jpg',
            'panchakarma' => 'Panchakarma-Therapy.jpg',
            'yoga-therapy' => 'Yoga%20Therapy.jpg',
            'ayurvedic-diet' => 'Ayurvedic-Diet-Nutrition.jpg',
            'online-consultation' => 'Online-Consultation.jpg',
            default => null,
        };

        return $image ? asset('images/instant-ayurved/img/services/'.$image) : null;
    }

}
