<?php
/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace ArrayToJson\Controller;

use ArrayToJson\Form\ArrayToJsonForm;
use ArrayToJson\Model\ArrayToJson;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class ArrayToJsonController
 * @package ArrayToJson\Controller
 */
class ArrayToJsonController extends AbstractActionController
{
    /**
     * @return ArrayToJsonForm[]|ViewModel
     */
    public function indexAction()
    {
        $form = new ArrayToJsonForm();
        $form->get('submit')->setValue('Format');

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $arrayToJson = new ArrayToJson();
        $form->setInputFilter($arrayToJson->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $error = false;
        $result = null;
        try {
            $value = $this->getRequest()->getPost()->get('array');
            // @todo: eval is a big no no. write script to parse string one day :(
            $data = @eval('$result = ' . $value . '; return true;');
            if (!is_array($result) || !$data) {
                $error = true;
            }
            $result = json_encode($result);
        } catch (\ParseError $ex) {
            $error = true;
        }

        if ($error) {
            return new ViewModel(['form' => $form, 'error' => 'Invalid PHP array given']);
        }
        return new ViewModel(['form' => $form, 'array' => $result]);
    }
}
