<?php

// ItemEntryService.php

namespace App\Services;

use App\Models\ItemEntry;
use Carbon\Carbon;

class ItemEntryService
{
    public function createItemEntry($entryType, $postingDate, $itemId, $documentNo, $extDocNo, $uom, $locationId, $documentableType, $documentableId)
    {
        // You may want to perform validation or other checks here before creating the entry.

        $itemEntry = new ItemEntry();
        $itemEntry->entry_type = $entryType;
        $itemEntry->posting_date = Carbon::parse($postingDate);
        $itemEntry->item_id = $itemId;
        $itemEntry->document_no = $documentNo;
        $itemEntry->ext_doc_no = $extDocNo;
        $itemEntry->uom = $uom;
        $itemEntry->location_id = $locationId;
        $itemEntry->documentable_type = $documentableType;
        $itemEntry->documentable_id = $documentableId;

        $itemEntry->save();

        return $itemEntry;
    }
}

