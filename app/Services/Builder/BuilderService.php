<?php

declare(strict_types=1);

namespace App\Services\Builder;

/**
 * BuilderService
 *
 * Minimal service to register and retrieve block render callbacks.
 */
class BuilderService
{
    /** @var array<string, callable> */
    protected array $callbacks = [];

    /**
     * Register a render callback for a block type.
     */
    public function registerBlockRenderCallback(string $blockType, callable $callback): void
    {
        $this->callbacks[$blockType] = $callback;
    }

    /**
     * Whether a callback exists for the given block type.
     */
    public function hasBlockRenderCallback(string $blockType): bool
    {
        return array_key_exists($blockType, $this->callbacks);
    }

    /**
     * Get the registered callback for a block type, or null.
     *
     * @return callable|null
     */
    public function getBlockRenderCallback(string $blockType): ?callable
    {
        return $this->callbacks[$blockType] ?? null;
    }

    /**
     * Inject registered blocks to frontend for a given context.
     *
     * @param string $context The context (e.g., 'page', 'post')
     * @return string Rendered HTML for the context
     */
    public function injectToFrontend(string $context = 'page'): string
    {
        // For now, return empty string as a placeholder
        // Future: This could render registered blocks for the context
        return '';
    }
}
