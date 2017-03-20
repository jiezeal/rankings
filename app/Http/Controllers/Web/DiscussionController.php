<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\PublishDiscussionRequest;
use App\Services\DiscussionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{
    /**
     * @var DiscussionService
     */
    protected $discussionService;

    /**
     * DiscussionController constructor.
     * @param DiscussionService $discussionService
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update']]);
    }
    
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $discussions = $this->discussionService->paginate(PAGENUM);
        return view('web.forum.index', compact('discussions'));
    }
    
    /**
     * 帖子详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $discussion = $this->discussionService->getRaw($id);
        return view('web.forum.show', compact('discussion'));
    }

    /**
     * 发表帖子界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('web.forum.create');
    }

    /**
     * 发表一篇帖子
     * @param PublishDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PublishDiscussionRequest $request){
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $data['last_user_id'] = \Auth::user()->id;
        $discussion = $this->discussionService->publish($data);
        if(!$discussion){
            return redirect('/web/index');
        }
        return redirect('/web/index/'.$discussion->id);
    }

    /**
     * 编辑帖子界面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id){
        $discussion = $this->discussionService->getRaw($id);
        // 只能编辑自己发的帖子
        if(\Auth::user()->id != $discussion->user_id){
            return redirect('/web/index');
        }
        return view('web.forum.edit', compact('discussion'));
    }

    /**
     * 修改一篇帖子
     * @param $id
     * @param PublishDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PublishDiscussionRequest $request, $id){
        $data = $request->all();
        $discussion = $this->discussionService->modify($data, $id);
        if($discussion){
            return redirect('/web/index/'.$discussion->id);
        }else{
            return redirect('/web/index/'.$discussion->id.'/edit');
        }
    }
}
