<?php

namespace App\Enums;

use App\Traits\EnumHelpers;

enum OrderStatus: string
{
    use EnumHelpers;

    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    /**
     * Get status label for display
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    /**
     * Get status color for UI display
     */
    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::PROCESSING => 'blue',
            self::SHIPPED => 'purple',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
        };
    }

    /**
     * Check if status can be updated to another status
     */
    public function canTransitionTo(OrderStatus $status): bool
    {
        return match($this) {
            self::PENDING => in_array($status, [self::PROCESSING, self::CANCELLED]),
            self::PROCESSING => in_array($status, [self::SHIPPED, self::CANCELLED]),
            self::SHIPPED => in_array($status, [self::COMPLETED]),
            self::COMPLETED => false, // Final status
            self::CANCELLED => false, // Final status
        };
    }

    /**
     * Get next possible statuses
     */
    public function getNextStatuses(): array
    {
        return match($this) {
            self::PENDING => [self::PROCESSING, self::CANCELLED],
            self::PROCESSING => [self::SHIPPED, self::CANCELLED],
            self::SHIPPED => [self::COMPLETED],
            self::COMPLETED => [],
            self::CANCELLED => [],
        };
    }
}
