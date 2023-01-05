<li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'items','action' => 'index']); ?>">商品一覧</a></li>
<li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index', '?' => ['page_slug' => $page_config->slug, 'item_id' => $item->id]]); ?>">レポート一覧</a></li>
<li class="breadcrumb-item active"><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>