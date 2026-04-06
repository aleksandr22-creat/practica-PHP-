<?php

namespace Controller;

use Model\Dissertation;
use Src\Request;
use Src\View;

class DefenseReportController
{
    public function show(Request $request): string
    {
        $count = 0;
        if ($request->method === 'POST') {
            $count = Dissertation::where('status', 'защищена')
                ->whereBetween('approval_date', [$request->start_date, $request->end_date])
                ->count();
        }
        return (new View())->render('reports.defenses', ['count' => $count]);
    }
}
