<?php
/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace FormatXml\Controller;

use FormatXml\Form\FormatXmlForm;
use FormatXml\Model\FormatXml;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class FormatXmlController
 * @package FormatXml\Controller
 */
class FormatXmlController extends AbstractActionController
{
    /**
     * @return FormatXmlForm[]|ViewModel
     */
    public function indexAction()
    {
        $form = new FormatXmlForm();
        $form->get('submit')->setValue('Format');

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $formatXml = new FormatXml();
        $form->setInputFilter($formatXml->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $error = false;
        $formattedXml = null;
        try {
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($this->getRequest()->getPost()->get('xml'));
            $dom->formatOutput = TRUE;
            $formattedXml = $dom->saveXml();
            if (!$formattedXml) {
                $error = true;
            }
        } catch (\Exception $ex) {
            $error = true;
        }

        if ($error) {
            return new ViewModel(['form' => $form, 'error' => 'Invalid PHP array given']);
        }
        return new ViewModel(['form' => $form, 'xml' => $formattedXml]);
    }
}
