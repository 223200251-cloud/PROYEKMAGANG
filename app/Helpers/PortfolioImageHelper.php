<?php

namespace App\Helpers;

use App\Models\Portfolio;

class PortfolioImageHelper
{
    /**
     * Get image URL berdasarkan tipe (uploaded atau url)
     * 
     * @param Portfolio $portfolio
     * @return string|null
     */
    public static function getImageUrl(Portfolio $portfolio): ?string
    {
        if ($portfolio->image_type === 'uploaded' && $portfolio->image_path) {
            return asset('storage/' . $portfolio->image_path);
        }
        return $portfolio->image_url;
    }

    /**
     * Get image alt text
     * 
     * @param Portfolio $portfolio
     * @return string
     */
    public static function getImageAlt(Portfolio $portfolio): string
    {
        return $portfolio->title . ' - ' . $portfolio->user->name;
    }

    /**
     * Cek apakah image adalah uploaded file
     * 
     * @param Portfolio $portfolio
     * @return bool
     */
    public static function isUploadedImage(Portfolio $portfolio): bool
    {
        return $portfolio->image_type === 'uploaded' && !empty($portfolio->image_path);
    }

    /**
     * Cek apakah image adalah URL eksternal
     * 
     * @param Portfolio $portfolio
     * @return bool
     */
    public static function isExternalImage(Portfolio $portfolio): bool
    {
        return $portfolio->image_type === 'url' && !empty($portfolio->image_url);
    }

    /**
     * Delete image file jika ada
     * 
     * @param Portfolio $portfolio
     * @return bool
     */
    public static function deleteImageFile(Portfolio $portfolio): bool
    {
        if (self::isUploadedImage($portfolio)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image_path);
        }
        return false;
    }
}
