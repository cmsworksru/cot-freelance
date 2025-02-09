<?php
/**
 * Events for freelance
 * Event DTO
 * @package flevents
 * @author Cotonti team
 * @copyright Copyright (c) 2024-2025 Cotonti team
 */

declare(strict_types=1);

namespace cot\plugins\flevents\inc;

class EventDto
{
    public string $source;
    public int $sourceId;
    public string $type;
    public string $date;
    public int $toUserId;
    public ?int $fromUserId = null;
    public int $status = EventDictionary::STATUS_NEW;

}