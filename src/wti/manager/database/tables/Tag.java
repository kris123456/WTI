package wti.manager.database.tables;

import java.util.List;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

import org.hibernate.Criteria;
import org.hibernate.Session;

import wti.manager.interfaces.INamedTableRow;
import wti.manager.utils.Utils;

@Entity
@Table(name = "tag")
public class Tag implements INamedTableRow<Tag> {

	@Id
	@Column(name = "id_tag")
	private int id = 0;
	
	@Column(name = "name_tag", nullable = false)
	private String name = "";

	
	public Tag() {
	}
	
	public int getId() {
		return id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
	
	public static List<Tag> getAll(Session session) {
		Criteria criteria = session.createCriteria(Tag.class);
		@SuppressWarnings("unchecked")
		List<Tag> tags = criteria.list();
		return tags;
	}
	
	@Override
	public String toString() {
		return "Tag["+id+"](\""+name+"\")";
	}
	
	public Tag clone() {
		Tag tag = new Tag();
		tag.id = id;
		tag.name = name;
		return tag;
	}
	
	@Override
	public boolean equals(Object obj) {
		if (obj == this)
			return true;
		if (!(obj instanceof Tag))
			return false;
		Tag tag = (Tag) obj;
		
		boolean idOk = tag.id == id;
		boolean nameOk = tag.name.equals(name);
		return Utils.equalsFromBools(idOk, nameOk);
	}
	
	@Override
	public int hashCode() {
		int idHash = id;
		int nameHash = name.hashCode();
		return Utils.hashFromInts(idHash, nameHash);
	}
	
}