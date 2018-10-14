<?php
$L_NAME_HINT = 'How the entry is uniquely identified.  Keep the name precise and clearly understood.';
$L_DATALIST_HINT = 'Input must be an item from the dropdown.';
$L_NUMBER_HINT = 'Entry must be a number. Units (e.g. ft, lbs) should not be included.';
$L_DATALIST_ANY_HINT = 'Input can be an item from the dropdown or a custom item.';
$L_DESCRIPTION_HINT = 'Input should clearly descripe the entry.  Add any properties of the entry that were not already defined in other fields.';
$L_TYPE_ABILITY_HINT = 'Only certain types of abilities can be used in certain form entries';
$L_TARGET_HINT = 'The target of the spell or ability.  If there is no target, it should probably be Self.<br>
<b>AoE:</b> will target all inside the Area of Effect; center is determined by Range.<br>
<b>Self:</b> only able to target self.<br>
<b>Target:</b> selectively target within Range.';
$L_NUM_TARGET_HINT = 'If a spell or ability has a specific number of targets, you can set it here.  If target is Self or AoE, leave blank.';
$L_RANGE_HINT = 'If the Radius type is Beam, the Range indicates the length of a beam.  Otherwise, Range may extends the spell or ability\'s center to that Range.';
$L_RADIUS_HINT = 'See Radius type for different Radius effects.';
$L_RADIUS_TYPE_HINT = '<b>Beam:</b> Range long and Radius wide.<br>
<b>Cone:</b> Radius long and Radius wide at end making a cone shape.<br>
<b>Cylinder:</b> circle of Radius around target and infinite height.<br>
<b>Sphere:</b> sphere of Radius around target.';
$L_WEIGHT_HINT = 'For determining if carrier is overloaded. 0 Weight signifies that there is no burden for carrying the item.';
$L_VALUE_HINT = 'What the standard purchase price is of an item. However, Items of 0 Value cost 1 but sell for 0.';
$L_PRIMARY_TYPE_ITEM_HINT = 'Different items have different properties.';
$L_TYPE_AMMUNITION_HINT = 'Most ranged weapons require a particular ammunition type, as specified here.';
$L_QUANTITY_VALUE_HINT = 'Number of this item you can purchase for the given Value.';
$L_RARITY_HINT = 'The likelihood of coming across this item.<br>
<b>Common:</b> can be purchased at typical market.<br>
<b>Uncommon:</b> usually only found by adventuring.<br>
<b>Rare:</b> about 10x less common than Uncommon.<br>
<b>Legendary:</b> only the greatest of heros find such an item.';
$L_SECONDARY_ARMOR_TYPE_HINT = 'Different armor types affect the wearer.<br>
<b>Cloth:</b> no effect.<br>
<b>Heavy:</b> Specify that there is a disadvantage Stealth check in the Description.<br>
<b>Light:</b> Armor modifier + DEX<br>
<b>Medium:</b> Armor modifier + STR<br>
<b>Other:</b> if not body armor.  Specify which part of the body it covers in the Description.<br>
<b>Shield:</b> held in one hand.';
$L_ARMOR_MOD_HINT = 'Added to defense against physical attacks.  If hit by physical attack, hit roll is reduced by Armor amount.';
$L_DODGE_MOD_HINT = 'Added to defense.';
$L_MAGIC_RESIST_MOD_HINT = 'Added to defense against magical attacks.  If hit by magical attack, hit roll is reduced by Magic resist amount.';
$L_SECONDARY_CONSUMABLE_TYPE_HINT = 'All consumable types can be used only once.';
$L_LOCALITY_HINT = 'In what conditions can you typically find this ingredient.';
$L_HIDDEN_PROPERTY_HINT = 'This property is only revealed when the item is used.  If the item can be testd in certain ways, they can be listed here as well.';
$L_THROW_HINT = 'Maximum range at which a weapon can be thrown to deal damage. Leave blank if weapon cannot be thrown.';
$L_WEAPON_RANGE_HINT = 'Maximum range at which an ammunition can be fired from the weapon.';
$L_DAMAGE_HINT = 'Extra damage a weapon inflicts if it hits.';
$L_DAMAGE_TYPE_HINT = 'Type of damage the weapon deals if it hits.';
$_SECONDARY_ = 'Additional damage that a weapon inflicts per action or an alternative damage that can be inflicted.  This should be specified in the Description.';
$L_SECONDARY_DAMAGE_HINT = $_SECONDARY_ .'<br>'.$L_DAMAGE_HINT;
$L_SECONDARY_DAMAGE_TYPE_HINT = $_SECONDARY_ .'<br>'.$L_DAMAGE_TYPE_HINT;
$L_ATTRIBUTE_HINT = 'Must be one of the four attributes.  Attributes determine what skills can be increased and raw skill when needed.
<b>STR (Strength):</b> Affects maximum health and weapon damage.<br>
<b>DEX (Dexterity):</b> Affects dodge modifier and hit chance.<br>
<b>INF (Influence):</b> Affects most spell casting and charisma.<br>
<b>WIS (Wisdom):</b> Affects overall perception of a character.';
$L_SKILL_TYPE_HINT = 'CORE skills are common rules that any character can start with.  You may create other skills, but the use of such is still tbd.';
$L_DICE_HINT = 'Entry can be a positive number or a dice number. A dice number looks like 2d6+4; meaning roll 2 six-sided dice and add 4 to the end result. The modifier can be (+, -, *, or /) and a number, and is not required.'; 
$L_SPELL_LEVEL_HINT = 'Before a spell of a given level can be used, a character must meet that requirement for his Class or Race.  Higher level spells are usually more powerful.';
$L_MANA_COST_HINT = 'Spells consume mana; powerful spells that deal heavy damage cost high mana, whereas bursty spells cost little mana.  Mana is slowly regenerated.';
$L_CAST_TIME_HINT = 'Time required to cast the spell. Common cast times are 1 action, 1 turn, the encounter, or 1 hour.';
$L_COMPONENTS_HINT = 'Certain spells require special components before being cast. You may look through the dropdown options to see some examples.';
$L_DURATION_HINT = 'How long does the effect last.  Common durations are 1 turn, the encounter, 1 hour, 1 month, or permanent.';
?>
