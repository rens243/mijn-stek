<?php


namespace App\Http\Livewire;

use Livewire\WithPagination as LivewireWithPagination;

trait WithPagination
{
    use LivewireWithPagination;

    protected function emitGoToTop()
    {
        $this->emit("goToTop");
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
        $this->emitGoToTop();
    }

    public function previousPage()
    {
        $this->setPage(max($this->page - 1, 1));
        $this->emitGoToTop();
    }

    public function nextPage()
    {
        $this->setPage($this->page + 1);
        $this->emitGoToTop();
    }

    public function resolvePage()
    {
        // The "page" query string item should only be available
        // from within the original component mount run.
        return (int) request()->query('page', $this->page);
    }
}
