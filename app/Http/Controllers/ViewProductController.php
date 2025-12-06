<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewProductController extends Controller
{
    public function list(Request $request)
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->get()
            ->map(fn ($product) => $this->formatProductForGrid($product))
            ->values();

        $categories = Category::query()
            ->where('visible', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Customer/BrowseGadgets', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, Product $product)
    {
        return Inertia::render('Customer/ViewDetailsGadget', [
            'gadget' => $this->formatProductForDetail($product),
            'showRentForm' => (bool) $request->boolean('rent'),
        ]);
    }

    public function rent(Product $product)
    {
        return Inertia::render('Customer/ViewDetailsGadget', [
            'gadget' => $this->formatProductForDetail($product),
            'showRentForm' => true,
        ]);
    }

    private function formatProductForGrid(Product $product): array
    {
        $payload = $this->buildProductPayload($product);

        return [
            'id' => $payload['id'],
            'name' => $payload['name'],
            'category' => $payload['category'],
            'category_id' => $payload['category_id'],
            'price_per_day' => $payload['price_per_day'],
            'image_url' => $payload['primary_image'],
            'features' => array_slice($payload['features'], 0, 4),
            'detailsUrl' => $payload['detailsUrl'],
            'rentUrl' => $payload['rentUrl'],
        ];
    }

    private function formatProductForDetail(Product $product): array
    {
        $payload = $this->buildProductPayload($product);

        return [
            'id' => $payload['id'],
            'name' => $payload['name'],
            'category' => $payload['category'],
            'category_id' => $payload['category_id'],
            'price_per_day' => $payload['price_per_day'],
            'images' => $payload['images'],
            'specs' => $payload['specs'],
            'features' => $payload['features'],
            'description' => $payload['description'],
            'included_items' => $payload['included_items'],
            'rentUrl' => $payload['rentUrl'],
        ];
    }

    private function buildProductPayload(Product $product): array
    {
        $product->loadMissing('category');

        $gallery = collect();

        $imagesAttribute = $product->images ?? null;

        // if (is_string($imagesAttribute) && filled($imagesAttribute)) {
        //     $decoded = json_decode((string) $imagesAttribute, true);
        //     if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        //         $gallery = collect($decoded);
        //     }
        // } elseif (is_array($imagesAttribute)) {
        //     $gallery = collect($imagesAttribute);
        // }

        $fallbackImages = collect([
            $product->image_url ?? null,
            $product->thumbnail_url ?? null,
            $product->cover_image ?? null,
            $product->primary_image ?? null,
        ])->filter();

        $gallery = $gallery->merge($fallbackImages)->filter()->unique()->values();

        if ($gallery->isEmpty()) {
            $gallery = collect([
                'https://via.placeholder.com/1200x800?text=' . urlencode($product->name),
            ]);
        }

        $rawFeatures = $product->feature_highlights ?? $product->features ?? null;

        if (is_string($rawFeatures)) {
            $rawFeatures = array_map('trim', preg_split('/[,;|\n]+/', $rawFeatures));
        } elseif ($rawFeatures instanceof \Illuminate\Support\Collection) {
            $rawFeatures = $rawFeatures->all();
        } elseif (!is_array($rawFeatures) || empty($rawFeatures)) {
            $rawFeatures = array_filter([
                $product->brand ?? null,
                $product->model ?? null,
                $product->condition ?? null,
                $product->color ?? null,
                $product->spec1 ?? null,
                $product->spec2 ?? null,
                $product->spec3 ?? null,
                $product->spec4 ?? null,
            ]);
        }

        $includedItems = $product->included_items ?? $product->accessories ?? null;

        if (is_string($includedItems)) {
            $includedItems = array_map('trim', preg_split('/[,;|\n]+/', $includedItems));
        } elseif ($includedItems instanceof \Illuminate\Support\Collection) {
            $includedItems = $includedItems->all();
        } elseif (!is_array($includedItems) || empty($includedItems)) {
            $includedItems = $rawFeatures;
        }

        $specs = [
            'processor' => $product->processor ?? $product->spec_processor ?? null,
            'battery' => $product->battery ?? $product->spec_battery ?? null,
            'storage' => $product->storage ?? $product->spec_storage ?? null,
            'display' => $product->display ?? $product->spec_display ?? null,
            'audio' => $product->audio ?? $product->spec_audio ?? null,
            'connectivity' => $product->connectivity ?? $product->spec_connectivity ?? null,
        ];

        $pricePerDay = $product->price_per_day ?? $product->daily_rate ?? $product->price ?? 0;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => optional($product->category)->name,
            'category_id' => $product->category_id,
            'price_per_day' => $pricePerDay,
            'primary_image' => $gallery->first(),
            'images' => $gallery->take(6)->values()->all(),
            'features' => collect($rawFeatures)->filter()->values()->all(),
            'included_items' => collect($includedItems)->filter()->take(6)->values()->all(),
            'specs' => collect($specs)
                ->map(fn ($value) => $value ?: 'Not specified')
                ->toArray(),
            'description' => $product->description ?? '',
            'detailsUrl' => route('gadgets.show', $product),
            'rentUrl' => route('gadgets.rent', $product),
        ];
    }
}