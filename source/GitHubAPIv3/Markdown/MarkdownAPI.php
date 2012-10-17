<?php

namespace GitHubAPIv3\Markdown;

use GitHubAPIv3\AbstractAPI;

class MarkdownAPI extends AbstractAPI
{

    public function renderMarkdown($text, $mode = null, $context = null)
    {
        $api = 'POST /markdown';

        $params = array('text' => $text);
        if ($mode) {
            $params['mode'] = $mode;
        }
        if ($context) {
            $params['context'] = $context;
        }

        $content = $this->doAPIRequest($api, $params);
        return $content;
    }

}
