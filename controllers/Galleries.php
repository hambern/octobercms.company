<?php namespace Hambern\Company\Controllers;

use BackendMenu;
use Flash;
use Hambern\Company\Models\Gallery;
use Lang;

/**
 * Galleries Back-end Controller
 */
class Galleries extends Controller
{

    public $requiredPermissions = ['hambern.company.access_galleries'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Hambern.Company', 'company', 'galleries');
    }

    /**
     * Deleted checked galleries.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $galleryId) {
                if (!$gallery = Gallery::find($galleryId)) {
                    continue;
                }

                $gallery->delete();
            }

            Flash::success(Lang::get('hambern.company::lang.galleries.delete_selected_success'));
        } else {
            Flash::error(Lang::get('hambern.company::lang.galleries.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
