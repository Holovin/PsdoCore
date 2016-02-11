<?php
    namespace PSDO\View\Document;

    use PSDO\View\Document;
    use PSDO\View\Widget;
    use PSDO\Config;

    class HtmlDocument extends Document {
        protected $title = null;
        protected $bodyContent = [];
        protected $out = [
            'html_title' => 'psdo!',
            'html_debug' => '',
            'html_head_last' => '',
            'html_content' => '',
            'html_last' => '<!-- psdo! -->',
        ];

        public function write($layout, $position, $widgetName, $widgetData) {
            $this->bodyContent[$layout][$position] = new Widget($widgetName, $widgetData);
        }

        public function writeRaw($data) {
            if (!array_key_exists('Blank', $this->bodyContent)) {
                $this->bodyContent['Blank']['data'] = '';
            }

            $this->bodyContent['Blank']['data'] .= $data;
        }

        public function appendWidgetRaw($widgetName, $widgetData) {
            $this->out['html_debug'] = new Widget($widgetName, $widgetData);
        }

        public function render() {
            foreach ($this->bodyContent as $layout => $data) {
                $this->out['html_content'] .= new Widget('Layout/'.$layout, $data);
            }

            // TODO: maybe add here layout support?
            // Can replace str /BashHtml/ to another!
            echo new Widget('Document/BaseHtml', $this->out);
        }

        public function setData($key, $value) {
            if (array_key_exists($key, $value)) {
                $this->out[$key] = $value;
            }
        }
    }