<?php

namespace App\Traits;

use App\Models\Meta;

trait HasMeta
{
    public function metas() {
        return $this->hasMany(Meta::class, 'model_id');
    }

    public function updateMeta($key, $value_rus, $value_eng, $page_id) {
        $meta = Meta::where(['key' => $key, 'model_id' => $page_id])->first();

        if ($meta->exists()) {
            error_log($value_eng);
            return $meta->update(['value_eng' => $value_eng, 'value_rus' => $value_rus]);
        }
        error_log($this->id);

        return Meta::create([
            'key' => $key,
            'value_rus' => $this->maybeEncodeMetaValue($value_rus),
            'value_eng' => $this->maybeEncodeMetaValue($value_eng),
            'model_type' => get_class($this),
            'model_id' => $page_id
        ]);
    }

    public function createMeta($key, $value_rus, $value_eng, $page_id) {
        return Meta::create([
            'key' => $key,
            'value_rus' => $this->maybeEncodeMetaValue($value_rus),
            'value_eng' => $this->maybeEncodeMetaValue($value_eng),
            'model_type' => get_class($this),
            'model_id' => $page_id
        ]);
    }

    public function deleteMeta($key) {
        return Meta::where(['key' => $key, 'model_id' => $this->id])->delete();
    }
		
    public function getMeta($key, $lang = 'eng') {
        $meta = Meta::where(['key' => $key, 'model_id' => $this->id])
            ->first();

        if (empty($meta->value_eng)) {
            return null;
        }
        if ($lang == 'eng') {
            return $this->maybeDecodeMetaValue($meta->value_eng);
        } else {
            return $this->maybeDecodeMetaValue($meta->value_rus);
        }
    }

    protected function maybeDecodeMetaValue($value) {
        $object = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $object;
        }

        return $value;
    }

    protected function maybeEncodeMetaValue($value) {
        if (is_object($value) || is_array($value)) {
            return json_encode($value, true);
        }
        return $value;
    }

}