<?php

use App\Support\ImageUrlResolver;

it('normalizes storage image paths to public urls', function () {
    expect(ImageUrlResolver::toPublicUrl('storage/images/car.jpg'))->toBe('/images/car.jpg');
    expect(ImageUrlResolver::toPublicUrl('/storage/images/car.jpg'))->toBe('/images/car.jpg');
    expect(ImageUrlResolver::toPublicUrl('public/images/car.jpg'))->toBe('/images/car.jpg');
    expect(ImageUrlResolver::toPublicUrl('/images/car.jpg'))->toBe('/images/car.jpg');
    expect(ImageUrlResolver::toPublicUrl('https://cdn.example.com/car.jpg'))->toBe('https://cdn.example.com/car.jpg');
    expect(ImageUrlResolver::toPublicUrl(null))->toBe('/images/default-car.png');
});
