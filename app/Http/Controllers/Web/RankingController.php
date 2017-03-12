<?php

namespace App\Http\Controllers\Web;

use App\Services\DiscussionService;
use App\Services\RankingService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RankingController extends Controller
{
    /**
     * @var
     */
    protected $rankingService;
    protected $discussionService;

    /**
     * RankingController constructor.
     * @param RankingService $rankingService
     */
    public function __construct(RankingService $rankingService, DiscussionService $discussionService)
    {
        $this->rankingService = $rankingService;
        $this->discussionService = $discussionService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $data = $request->all();
        $ranking = $this->rankingService->ranking($data);
        if($ranking){
            return Response()->json(['ServerTime' => time(), 'ServerNo' => 'SN000', 'ResultData' => $ranking]);
        }else{
            return Response()->json(['ServerTime' => time(), 'ServerNo' => 'SN400', 'ResultData' => '点赞失败']);
        }
    }

    /**
     * 点赞详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $discussion = $this->discussionService->getRaw($id);
        return view('web.ranking.show', compact('discussion'));
    }

    /**
     * 点赞排行
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rankingList(){
        $discussions = $this->discussionService->getAll();
        return view('web.ranking.rankinglist', compact('discussions'));
    }
}
