<?php
// This file is part of Fbcomments - https://github.com/ankitagarwal/moodle-block_fbcomments
//
// Fbcomments is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Fbcomments is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// For GNU General Public License, see <http://www.gnu.org/licenses/>.



/**
 * fbcomments block class.
 *
 * @package   block_fbcomments
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_fbcomments extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_fbcomments');
    }

    public function has_config() {
        return false;
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('newfbblock', 'block_fbcomments'));
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function get_content() {
        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        }
        $fblike = null;
        $fbcomment = null;
        $this->content = new stdClass();
        // Config wont be set if block is just added.
        if (!empty($this->config->urltype)) {
            switch ($this->config->urltype) {
                case 4 : $url = $this->get_mod_url();
                        break;
                case 3 : $url = $this->get_course_url();
                        break;
                case 2 : $url = new moodle_url($CFG->wwwroot);
                        break;
                case 1 :
                default : $url = $this->page->url;
                        break;
            }
        } else {
            // No point going any further.
            return '';
        }
        $url = $url->out(true);

        $this->content->text = '<div id="fb-root"></div>';
        $jscode = '(function(d, s, id) {
    	  var js, fjs = d.getElementsByTagName(s)[0];
    	  if (d.getElementById(id)) return;
    	  js = d.createElement(s); js.id = id;
    	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    	  fjs.parentNode.insertBefore(js, fjs);
    	}(document, "script", "facebook-jssdk"));';
        $this->page->requires->js_init_code($jscode);

        $color = $this->config->colorscheme;
        if (!empty($this->config->enablelike)) {
            $fblike = '<div class="fb-like" data-send="false" data-href="'.$url.'" data-show-faces="false" colorscheme="'.$color.'"></div>';
        }
        if (!empty($this->config->enablecomment)) {
            if (empty($this->config->numposts)) {
                $this->config->numposts = 10;
            }
            $fbcomment = '<div class="fb-comments" data-href="'.$url.'" data-num-posts="'.$this->config->numposts.'" colorscheme="'.$color.'"></div>';
        }
        $this->content->text .= $fblike;
        $this->content->text .= $fbcomment;

        return $this->content;
    }

    /**
     * Return course url, which current page belongs to.
     *
     * @return moodle_url
     */
    public function get_course_url() {
        $context = $this->context->get_course_context();
        return $url = new moodle_url($context->get_url());
    }

    /**
     * Return mod url, which current page belongs to.
     *
     * @return moodle_url
     */
    public function get_mod_url() {
        // Context of the page holding the block.
        $context = $this->page->context;
        return $url = new moodle_url($context->get_url());
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }
}
