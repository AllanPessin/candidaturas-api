<?php

namespace Tests\Feature;

use Tests\TestCase;

class DocsViewTest extends TestCase
{
    public function test_a_docs_view_can_be_rendered()
    {
        $view = $this->view('docs.docs');

        $view->assertSee('Documentação da API - Candidaturas');
    }
}
