<?php
/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace FormatSql\Controller;

use FormatSql\Form\FormatSqlForm;
use FormatSql\Model\FormatSql;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class FormatSqlController
 * @package FormatSql\Controller
 */
class FormatSqlController extends AbstractActionController
{
    /**
     * @return FormatSqlForm[]|ViewModel
     */
    public function indexAction()
    {
        $form = new FormatSqlForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $album = new FormatSql();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $error = false;
        $formattedSql = null;
        try {
            $formattedSql = \SqlFormatter::format($this->getRequest()->getPost()->get('sql'), true);
            $form->setData(['sql' => $formattedSql]);
        } catch (\Exception $ex) {
            $error = true;
        }

        $request = $this->getRequest();
        $album = new FormatSql();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if ($error) {
            return new ViewModel(['form' => $form, 'error' => 'Invalid PHP array given']);
        }
        return new ViewModel(['form' => $form, 'sql' => $formattedSql]);
    }
}
