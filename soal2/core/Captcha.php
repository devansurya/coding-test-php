<?php
// Class Captcha - generate dan validasi security image (GD Library)
class Captcha
{
    private const CHARS  = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789';
    private const LENGTH = 5;
    private const WIDTH  = 200;
    private const HEIGHT = 50;

    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    // Generate teks captcha acak dan simpan di session
    public function generateText(): string
    {
        $text = '';
        $max = strlen(self::CHARS) - 1;

        for ($i = 0; $i < self::LENGTH; $i++) {
            $text .= self::CHARS[random_int(0, $max)];
        }

        $this->session->set('captcha', $text);
        return $text;
    }

    // Render gambar captcha ke browser
    public function render(): void
    {
        $text = $this->generateText();

        $image = imagecreatetruecolor(self::WIDTH, self::HEIGHT);

        $bgColor    = imagecolorallocate($image, 255, 255, 255);
        $textColor  = imagecolorallocate($image, 0, 0, 0);
        $noiseColor = imagecolorallocate($image, 150, 150, 150);
        $lineColor  = imagecolorallocate($image, 200, 200, 200);

        imagefilledrectangle($image, 0, 0, self::WIDTH, self::HEIGHT, $bgColor);

        $this->drawNoiseLines($image, $lineColor);
        $this->drawNoisePixels($image, $noiseColor);
        $this->drawText($image, $text, $textColor);

        header('Content-Type: image/png');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        imagepng($image);
        imagedestroy($image);
    }

    // Validasi input captcha dari user
    public function validate(string $input): bool
    {
        $stored = $this->session->get('captcha');
        $this->session->remove('captcha');

        if (empty($stored) || empty($input)) {
            return false;
        }

        return strtoupper(trim($input)) === $stored;
    }

    // Gambar garis noise
    private function drawNoiseLines($image, int $color): void
    {
        for ($i = 0; $i < 5; $i++) {
            imageline(
                $image,
                random_int(0, self::WIDTH),
                random_int(0, self::HEIGHT),
                random_int(0, self::WIDTH),
                random_int(0, self::HEIGHT),
                $color
            );
        }
    }

    // Gambar pixel noise
    private function drawNoisePixels($image, int $color): void
    {
        for ($i = 0; $i < 100; $i++) {
            imagesetpixel(
                $image,
                random_int(0, self::WIDTH),
                random_int(0, self::HEIGHT),
                $color
            );
        }
    }

    // Tulis teks captcha
    private function drawText($image, string $text, int $color): void
    {
        $spacing = (self::WIDTH - 20) / self::LENGTH;

        for ($i = 0; $i < self::LENGTH; $i++) {
            $x = 10 + ($i * $spacing) + random_int(-3, 3);
            $y = random_int(14, 24);
            imagestring($image, 5, (int) $x, (int) $y, $text[$i], $color);
        }
    }
}
