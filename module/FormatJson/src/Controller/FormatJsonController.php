<?php
/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace FormatJson\Controller;

use FormatJson\Form\FormatJsonForm;
use FormatJson\Model\FormatJson;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class FormatJsonController
 * @package FormatJson\Controller
 */
class FormatJsonController extends AbstractActionController
{
    /**
     * @return FormatJsonForm[]|ViewModel
     */
    public function indexAction()
    {
        $form = new FormatJsonForm();
        $form->get('submit')->setValue('Format');

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $formatJson = new FormatJson();
        $form->setInputFilter($formatJson->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $error = false;
        $formattedJson = null;
        try {
            $formattedJson = $this->formatJson($this->getRequest()->getPost()->get('json'));
        } catch (\Exception $ex) {
            $error = true;
        }

        if ($error) {
            return new ViewModel(['form' => $form, 'error' => 'Invalid PHP array given']);
        }
        return new ViewModel(['form' => $form, 'json' => $formattedJson]);
    }

    /**
     * @param $json
     * @return string
     */
    private function formatJson($json)
    {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen( $json );

        for( $i = 0; $i < $json_length; $i++ ) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if( $ends_line_level !== NULL ) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ( $in_escape ) {
                $in_escape = false;
            } else if( $char === '"' ) {
                $in_quotes = !$in_quotes;
            } else if( ! $in_quotes ) {
                switch( $char ) {
                    case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                    case '{': case '[':
                    $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
                }
            } else if ( $char === '\\' ) {
                $in_escape = true;
            }
            if( $new_line_level !== NULL ) {
                $result .= "\n".str_repeat( "    ", $new_line_level );
            }
            $result .= $char.$post;
        }

        return $result;
    }
}
