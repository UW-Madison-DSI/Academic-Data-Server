<?php
/******************************************************************************\
|                                                                              |
|                       InstitutionUnitController.php                          |
|                                                                              |
|******************************************************************************|
|                                                                              |
|        This is a controller for fetching info about units.                   |
|                                                                              |
|        Author(s): Abe Megahed                                                |
|                                                                              |
|        This file is subject to the terms and conditions defined in           |
|        'LICENSE.txt', which is part of this source code distribution.        |
|                                                                              |
|******************************************************************************|
|     Copyright (C) 2022, Data Science Institute, University of Wisconsin      |
\******************************************************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstitutionUnit;
use App\Models\Summaries\InstitutionUnitSummary;
use App\Models\Person;
use App\Http\Controllers\Controller;

class InstitutionUnitController extends Controller
{
	//
	// querying methods
	//

	/**
	 * Get a unit.
	 *
	 * @param string $id - the id of the institution unit to get
	 * @return App\Models\InstitutionUnit
	 */
	public function getIndex(string $id) {

		// find institution unit by id
		//
		$institutionUnit = InstitutionUnit::find($id);
		if (!$institutionUnit) {
			return response("Institution unit not found.", 404);
		}

		return $institutionUnit;
	}

	/**
	 * Get all units.
	 *
	 * @return App\Models\InstitutionUnit[]
	 */
	public function getAll() {
		// return InstitutionUnitSummary::all();
		return InstitutionUnitSummary::orderBy('name')->get();
	}

	/**
	 * Get all units with full info (num people and associates).
	 *
	 * @return App\Models\InstitutionUnit[]
	 */
	public function getFull() {
		// return InstitutionUnit::all();
		return InstitutionUnit::orderBy('name')->get();
	}

	/**
	 * Get people belonging to this unit.
	 *
	 * @return App\Models\Person[]
	 */
	public function getPeople($id) {
		return Person::where('primaryUnitAffiliationId', '=', $id)->get();
	}

	/**
	 * Get people affiliated with this unit.
	 *
	 * @return App\Models\Person[]
	 */
	public function getAffiliates($id) {
		return Person::where('nonPrimaryUnitAffiliationIds', 'like', '%' . $id . '%')->get();
	}
}