<?php

namespace App\Services;

use App\Shared\Models\NotificationTemplate;
use App\Shared\Models\PlatformAnnouncement;

class NotificationTemplateService
{
    /**
     * Get all active templates
     */
    public function getActiveTemplates(): \Illuminate\Database\Eloquent\Collection
    {
        return NotificationTemplate::active()->orderBy('name')->get();
    }

    /**
     * Get templates by type
     */
    public function getTemplatesByType(string $type): \Illuminate\Database\Eloquent\Collection
    {
        return NotificationTemplate::active()->byType($type)->get();
    }

    /**
     * Apply template to announcement
     */
    public function applyTemplate(PlatformAnnouncement $announcement, NotificationTemplate $template): PlatformAnnouncement
    {
        // Pre-fill announcement fields from template
        if (!$announcement->content) {
            $announcement->content = $template->content;
        }

        if (!$announcement->banner_html) {
            $announcement->banner_html = $template->banner_html;
        }

        if (!$announcement->banner_background_color || $announcement->banner_background_color === '#667eea') {
            $announcement->banner_background_color = $template->banner_background_color;
        }

        if (!$announcement->banner_text_color || $announcement->banner_text_color === '#ffffff') {
            $announcement->banner_text_color = $template->banner_text_color;
        }

        return $announcement;
    }

    /**
     * Create announcement from template
     */
    public function createFromTemplate(NotificationTemplate $template, array $data = []): PlatformAnnouncement
    {
        $announcement = new PlatformAnnouncement([
            'title' => $data['title'] ?? $template->name,
            'content' => $template->content,
            'type' => $data['type'] ?? 'info',
            'priority' => $data['priority'] ?? 3,
            'banner_html' => $template->banner_html,
            'banner_background_color' => $template->banner_background_color,
            'banner_text_color' => $template->banner_text_color,
            'show_as_banner' => $data['show_as_banner'] ?? true,
            'is_active' => $data['is_active'] ?? false,
        ]);

        // Apply any additional data
        foreach ($data as $key => $value) {
            if (in_array($key, $announcement->getFillable())) {
                $announcement->$key = $value;
            }
        }

        return $announcement;
    }
}

