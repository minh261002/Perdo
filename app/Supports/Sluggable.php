<?php
namespace App\Supports;

use Illuminate\Support\Str;

trait Sluggable
{

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootSluggable()
    {
        static::saving(function ($entity) {
            $entity->createSlug();
        });
    }

    public function createSlug()
    {
        $columnSlug = $this->columnSlug ?? 'name';
        $slug = Str::slug($this->slug ?: $this->$columnSlug);
        $allSlugs = $this->getRelatedSlugs($slug, $this->id);
        if (!$allSlugs->contains('slug', $slug)) {
            $this->slug = $slug;
            return $slug;
        }
        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                $this->slug = $newSlug;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return self::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}