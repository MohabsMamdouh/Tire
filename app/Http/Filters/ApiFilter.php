<?php

namespace App\Filters;

use Illuminate\Http\Request;


class ApiFilter
{
    protected $safeParms = [];

    protected $columnMap = [];


    protected $opreatorMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $opreators) {
            $query = $request->query($parm);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($opreators as $opreator) {
                if(isset($query[$opreator])) {
                    $eloQuery[] = [$column, $this->opreatorMap[$opreator], $query[$opreator]];
                }
            }
        }
        return $eloQuery;
    }
}
