<?php
/**
 * moodlefbcomments block class.
 *
 * @package   block_moodlefbcomments
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_moodlefbcomments extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_moodlefbcomments');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('newfbblock', 'block_moodlefbcomments'));
    }

    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG;

        if ($this->content !== NULL) {
            return $this->content;
        }
        $fblike = null;
        $fbcomment = null;
        $this->content = new stdClass();
        switch ($this->config->urltype) {
            case 2 : $url = new moodle_url($CFG->wwwroot);
                    break;
            case 1 :
            default : $url = $this->page->url;
                    break;

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
        if (!empty($this->config->enablelike)) {
            $fblike = '<div class="fb-like" data-send="false" data-href="'.$url.'" data-show-faces="false"></div>';
        }
        if (!empty($this->config->enablecomment)) {
            if (empty($this->config->numposts)) {
                $this->config->numposts = 10;
            }
            $fbcomment = '<div class="fb-comments" data-href="'.$url.'" data-num-posts="'.$this->config->numposts.'"></div>';
        }
        $this->content->text .= $fblike;
        $this->content->text .= $fbcomment;

        return $this->content;
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
