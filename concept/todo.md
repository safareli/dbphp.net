<solution>
 <kind>
</solution>


 <project default='{page}' kind='{kind}'>

 <page layout='{name}'>

 <layout name='{name}' title='{title}' grid='{grid}'>

 <type name='{name}' title='{title}' layout='{layout}' page='{page}'>
   <bind [base='{base}' name='{name}']/[unit='{unit}'] place='{place}' title='{title}' order='{order}'>
 </type>

class kind
{
    const site = 1;
    const admin = 2;
    const service = 3;
    public $id;
    public $name;
}

class project
{
    /**
    * lazy
    * enum
    * @var \core\kind
    */
    public $kind;
}

kind applies to project. project may have many kinds like admin,store or site,shop. when installing updates from xml:

<install>

</install>

<update module='shop' build='34'>
    <solution>
        ...
    </solution>

    <project apply='shop'>
        ...
    </project>

    <project apply='admin'>
        ...
    </project>
</update>


layout must not have project because its name is used in skins and if different projects have same layouts with different names for different things and share same skin than it might conflict