<?php

namespace App\Enum;

enum UserStatus: string
{
   
    case Active = 'active';
    case Deactive = 'deactive';
    case Blocked = 'blocked';
    case Pending= "pending";
    case Verified="verified";
    public function label(): string
    {
        return match ($this) {
        
            self::Active => 'Active',
            self::Deactive => 'Deactive',
            self::Blocked => 'Blocked',
            self::Pending => 'Pending',
            self::Verified => "Verified"
        };
    }

    public function badge(): string
    {
        return match ($this) {
          
            self::Active => 'success',
            self::Blocked => 'danger',
            self::Deactive => 'secondary',
            self::Pending =>"warning",
            self::Verified=>"info"
        };
    }
    public static function values(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }

    // ✅ Add this for value => label map
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($s) => [$s->value => $s->label()])->toArray();
    }
}
