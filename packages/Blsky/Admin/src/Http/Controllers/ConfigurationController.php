<?php

namespace Blsky\Admin\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Repositories\CoreConfigRepository;
use Webkul\Core\Tree;
use Illuminate\Support\Facades\Storage;
use Webkul\Admin\Http\Requests\ConfigurationForm;
use Webkul\Core\Repositories\ChannelRepository;

class ConfigurationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * CoreConfigRepository object
     *
     * @var \Webkul\Core\Repositories\CoreConfigRepository
     */
    protected $coreConfigRepository;

    /**
     * ChannelRepository object
     *
     * @var \Webkul\Core\Repositories\ChannelRepository
     */
    protected $channelRepository;

    /**
     *
     * @var array
     */
    protected $configTree;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\CoreConfigRepository  $coreConfigRepository
     *  @param  \Webkul\Core\Repositories\ChannelRepository  $channelRepository
     * @return void
     */
    public function __construct(CoreConfigRepository $coreConfigRepository,ChannelRepository $channelRepository)
    {
        $this->middleware('admin');

        $this->coreConfigRepository = $coreConfigRepository;
        $this->channelRepository = $channelRepository;

        $this->_config = request('_config');

        $this->prepareConfigTree();
    }

    /**
     * Prepares config tree
     *
     * @return void
     */
    public function prepareConfigTree()
    {
        $tree = Tree::create();

        foreach (config('blsky') as $item) {
            $tree->add($item);
        }

        $tree->items = core()->sortItems($tree->items);

        $this->configTree = $tree;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $slugs = $this->getDefaultConfigSlugs();

        if (count($slugs)) {
            return redirect()->route('blsky.configuration.index', $slugs);
        }
        $channel = $this->channelRepository->findOrFail(1);
        return view($this->_config['view'], ['config' => $this->configTree,'channel_repository' => $channel]);
    }

    /**
     * Returns slugs
     *
     * @return array
     */
    public function getDefaultConfigSlugs()
    {
        if (!request()->route('slug')) {
            $firstItem = current($this->configTree->items);
            $secondItem = current($firstItem['children']);

            return $this->getSlugs($secondItem);
        }

        if (!request()->route('slug2')) {
            $secondItem = current($this->configTree->items[request()->route('slug')]['children']);

            return $this->getSlugs($secondItem);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Webkul\Admin\Http\Requests\ConfigurationForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigurationForm $request)
    {
        Event::dispatch('core.configuration.save.before');
        $vsettings = request()->all();
        $this->coreConfigRepository->create($vsettings);

        Event::dispatch('core.configuration.save.after');

        // save channel settings
        $channel = $this->channelRepository->findOrFail(1);
        $data = $channel->toArray();
        $data['logo'] = $request->get('logo');
        $data['favicon'] = $request->get('favicon');
        $channel->update($data);

        $this->channelRepository->uploadImages($data, $channel);

        $this->channelRepository->uploadImages($data, $channel, 'favicon');

        session()->flash('success', trans('admin::app.configuration.save-message'));

        return redirect()->back();
    }
    /**
     * download the file for the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $path = request()->route()->parameters()['path'];

        $fileName = 'configuration/' . $path;

        $config = $this->coreConfigRepository->findOneByField('value', $fileName);

        return Storage::download($config['value']);
    }

    /**
     * @param  string  $secondItem
     * @return array
     */
    private function getSlugs($secondItem): array
    {
        $temp = explode('.', $secondItem['key']);

        return ['slug' => current($temp), 'slug2' => end($temp)];
    }
}
