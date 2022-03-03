<a href="{{isset($pUrl) ? $pUrl : 'javascript:;'}}">
<div class="bg-light" style="height: 20px">
    <div
      class="progress-bar bg-{{isset($pBgColour) ? $pBgColour : ''}}"
      role="progressbar"
      style="width: {{isset($pLevel) ? $pLevel : ''}}%"
      aria-valuenow="{{isset($pLevel) ? $pLevel : ''}}"
      aria-valuemin="0"
      aria-valuemax="100"
    >
      {{isset($pTitle) ? $pTitle : ''}} - {{isset($pLevel) ? $pLevel : ''}}%
    </div>
</div>
</a>
