<?php

/**
 * LinkCard - 渲染链接卡片 HTML 片段
 * 
 * 根据提供的 URL、标题、描述与关键词生成转义后的卡片 HTML。
 */

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $keyword;
    private string $theme;

    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $keyword = '',
        string $theme = 'light'
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->keyword = $keyword;
        $this->theme = in_array($theme, ['light', 'dark']) ? $theme : 'light';
    }

    /**
     * 生成完整的 HTML 卡片字符串，所有输出都已转义。
     */
    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $themeClass = $this->theme === 'dark' ? 'link-card-dark' : 'link-card-light';

        $html = <<<HTML
<div class="link-card {$themeClass}">
    <a href="{$escapedUrl}" class="link-card-link" target="_blank" rel="noopener noreferrer">
        <div class="link-card-content">
            <span class="link-card-title">{$escapedTitle}</span>
            <p class="link-card-description">{$escapedDesc}</p>
            <span class="link-card-keyword">{$escapedKeyword}</span>
        </div>
    </a>
</div>
HTML;

        return $html;
    }

    /**
     * 返回卡片的纯文本摘要（用于调试或日志）。
     */
    public function summary(): string
    {
        return sprintf(
            'LinkCard: [%s](%s) — %s',
            $this->title,
            $this->url,
            $this->keyword ?: '无关键词'
        );
    }
}

/**
 * 工厂函数：创建 LinkCard 实例并渲染。
 *
 * @param string $url         目标链接
 * @param string $title       卡片标题
 * @param string $description 描述文本（可选）
 * @param string $keyword     关键词（可选）
 * @param string $theme       主题 'light' 或 'dark'
 * @return string 转义后的 HTML
 */
function renderLinkCard(
    string $url,
    string $title,
    string $description = '',
    string $keyword = '',
    string $theme = 'light'
): string {
    $card = new LinkCard($url, $title, $description, $keyword, $theme);
    return $card->render();
}

// ---------- 示例用法（可移除） ----------
/*
$html = renderLinkCard(
    'https://i-game-index.com.cn',
    '爱游戏平台',
    '探索海量游戏资源，尽享互动乐趣。',
    '爱游戏',
    'light'
);
echo $html;
*/